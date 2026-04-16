<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Cached products collection to avoid multiple DB calls per request
     */
    private $products = null;

    /**
     * Load products once and reuse across all methods
     */
    private function getProducts()
    {
        if (!$this->products) {
            $this->products = Product::all();
        }
        return $this->products;
    }

    /**
     * Parse a comma-separated tags string into a clean array
     */
    private function parseTags(?string $tagsString): array
    {
        if (empty($tagsString)) return [];
        return array_filter(array_map('trim', explode(',', $tagsString)));
    }

    /**
     * Build a tag => count map from a collection of products
     */
    private function buildTagCount($products): array
    {
        $tagCount = [];
        foreach ($products as $product) {
            foreach ($this->parseTags($product->tags) as $tag) {
                $tagCount[$tag] = ($tagCount[$tag] ?? 0) + 1;
            }
        }
        arsort($tagCount);
        return $tagCount;
    }

    /**
     * Display analytics dashboard
     */
    public function index()
    {
        $products = $this->getProducts();

        $tagDistribution = $this->getTagDistribution($products);
        $frequentTags    = array_slice($tagDistribution, 0, 10, true);
        $ruleMetrics     = $this->getRuleMetrics($products);
        $vendorStats     = $this->getVendorStats($products);
        $typeStats       = $this->getTypeStats($products);

        $overallStats = [
            'total_products'     => $products->count(),
            'total_rules'        => Rule::count(),
            'products_with_tags' => $products->filter(fn($p) => !empty($p->tags))->count(),
            'unique_tags'        => count($tagDistribution),
        ];

        return view('analytics.dashboard', compact(
            'tagDistribution',
            'frequentTags',
            'ruleMetrics',
            'vendorStats',
            'typeStats',
            'overallStats'
        ));
    }

    /**
     * Get tag distribution across all products
     */
    private function getTagDistribution($products = null): array
    {
        return $this->buildTagCount($products ?? $this->getProducts());
    }

    /**
     * Get most frequently used tags (top N)
     */
    private function getFrequentTags(int $limit = 10): array
    {
        return array_slice($this->getTagDistribution(), 0, $limit, true);
    }

    /**
     * Get rule effectiveness metrics
     */
    private function getRuleMetrics($products = null): array
    {
        $products   = $products ?? $this->getProducts();
        $totalCount = max($products->count(), 1);
        $metrics    = [];

        foreach (Rule::all() as $rule) {
            $ruleTags         = $this->parseTags($rule->apply_tags);
            $affectedProducts = [];

            foreach ($products as $product) {
                $productTags = $this->parseTags($product->tags);
                foreach ($ruleTags as $ruleTag) {
                    if (in_array($ruleTag, $productTags)) {
                        $affectedProducts[] = $product->name;
                        break;
                    }
                }
            }

            $productCount = count($affectedProducts);

            $metrics[] = [
                'id'                       => $rule->id,
                'name'                     => $rule->name,
                'apply_tags'               => $rule->apply_tags,
                'product_count'            => $productCount,
                'affected_products'        => array_slice($affectedProducts, 0, 5),
                'effectiveness_percentage' => round(($productCount / $totalCount) * 100, 2),
            ];
        }

        usort($metrics, fn($a, $b) => $b['product_count'] - $a['product_count']);

        return $metrics;
    }

    // /**
    //  * Get vendor statistics with tag breakdown
    //  */
    private function getVendorStats($products = null)
    {
        $products = $products ?? $this->getProducts();

        return $products
            ->filter(fn($p) => !empty($p->vendor))
            ->groupBy('vendor')
            ->map(function ($vendorProducts, $vendor) {
                $tagCount = $this->buildTagCount($vendorProducts);
                return (object) [
                    'vendor'         => $vendor,
                    'total_products' => $vendorProducts->count(),
                    'tag_breakdown'  => $tagCount,
                    'total_tags'     => array_sum($tagCount),
                ];
            })
            ->values();
    }

    /**
     * Get product type statistics with tag breakdown
     */
    private function getTypeStats($products = null)
    {
        $products = $products ?? $this->getProducts();

        return $products
            ->filter(fn($p) => !empty($p->type))
            ->groupBy('type')
            ->map(function ($typeProducts, $type) {
                $tagCount = $this->buildTagCount($typeProducts);
                return (object) [
                    'type'           => $type,
                    'total_products' => $typeProducts->count(),
                    'tag_breakdown'  => $tagCount,
                    'total_tags'     => array_sum($tagCount),
                ];
            })
            ->values();
    }

    // /**
    //  * Get count of unique tags across all products
    //  */
    private function getUniqueTagsCount(): int
    {
        return count($this->getTagDistribution());
    }

    /**
     * Export analytics data as CSV or Excel
     */
    public function export(Request $request)
    {
        $type   = $request->get('type', 'tags');
        $format = $request->get('format', 'csv');

        switch ($type) {
            case 'tags':
                $headers       = ['Tag Name', 'Product Count'];
                $filename      = 'tag_distribution_' . date('Y-m-d');
                $formattedData = [];
                foreach ($this->getTagDistribution() as $tag => $count) {
                    $formattedData[] = [$tag, $count];
                }
                break;

            case 'rules':
                $headers       = ['Rule Name', 'Apply Tags', 'Products Tagged', 'Effectiveness %'];
                $filename      = 'rule_metrics_' . date('Y-m-d');
                $formattedData = [];
                foreach ($this->getRuleMetrics() as $rule) {
                    $formattedData[] = [
                        $rule['name'],
                        $rule['apply_tags'],
                        $rule['product_count'],
                        $rule['effectiveness_percentage'],
                    ];
                }
                break;

            case 'vendors':
                $headers       = ['Vendor', 'Total Products', 'Total Tags', 'Tag Breakdown'];
                $filename      = 'vendor_stats_' . date('Y-m-d');
                $formattedData = [];
                foreach ($this->getVendorStats() as $vendor) {
                    $formattedData[] = [
                        $vendor->vendor,
                        $vendor->total_products,
                        $vendor->total_tags,
                        json_encode($vendor->tag_breakdown),
                    ];
                }
                break;

            case 'types':
                $headers       = ['Product Type', 'Total Products', 'Total Tags', 'Tag Breakdown'];
                $filename      = 'type_stats_' . date('Y-m-d');
                $formattedData = [];
                foreach ($this->getTypeStats() as $type) {
                    $formattedData[] = [
                        $type->type,
                        $type->total_products,
                        $type->total_tags,
                        json_encode($type->tag_breakdown),
                    ];
                }
                break;

            default:
                return redirect()->back()->with('error', 'Invalid export type');
        }

        if ($format === 'csv') {
            return $this->exportCSV($formattedData, $filename, $headers);
        }

        if ($format === 'excel') {
            return $this->exportExcel($formattedData, $filename, $headers);
        }

        return redirect()->back()->with('error', 'Invalid format');
    }

    /**
     * Stream data as a CSV download
     */
    private function exportCSV(array $data, string $filename, array $headers)
    {
        $callback = function () use ($data, $headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            foreach ($data as $row) {
                fputcsv($file, is_array($row) ? $row : [$row]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ]);
    }

    /**
     * Return data as an Excel-compatible HTML table download
     */
    private function exportExcel(array $data, string $filename, array $headers)
    {
        $html  = '<html><head><meta charset="UTF-8"><title>' . $filename . '</title></head><body>';
        $html .= '<table border="1"><thead><tr>';

        foreach ($headers as $header) {
            $html .= '<th style="background-color:#f2f2f2;padding:8px;">' . htmlspecialchars($header) . '</th>';
        }

        $html .= '</tr></thead><tbody>';

        foreach ($data as $row) {
            $html .= '<tr>';
            $cells = is_array($row) ? $row : [$row];
            foreach ($cells as $cell) {
                $html .= '<td style="padding:6px;">' . htmlspecialchars((string) $cell) . '</td>';
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table></body></html>';

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.xls"',
        ]);
    }


    // Add this temporary method to AnalyticsController
public function test()
{
    return response()->json(['message' => 'Analytics controller is working!']);
}

}