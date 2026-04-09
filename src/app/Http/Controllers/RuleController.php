<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rules = Rule::with('conditions')->latest()->paginate(10);
        return view('rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                        => 'required|string|max:255',
            'apply_tags'                  => 'required|string',
            'conditions'                  => 'required|array|min:1',
            'conditions.*.product_selector' => 'required|in:type,sku,vendor,price,qty',
            'conditions.*.operator'       => 'required|in:==,>,<',
            'conditions.*.value'          => 'required|string',
        ]);

        $rule = Rule::create([
            'name'       => $request->name,
            'apply_tags' => $request->apply_tags,
        ]);

        foreach ($request->conditions as $condition) {
            $rule->conditions()->create($condition);
        }

        return redirect()->route('rules.index')
            ->with('success', 'Rule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rule $rule)
    {
        return redirect()->route('rules.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rule $rule)
    {
        $rule->load('conditions');
        return view('rules.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rule $rule)
    {
        $request->validate([
            'name'                        => 'required|string|max:255',
            'apply_tags'                  => 'required|string',
            'conditions'                  => 'required|array|min:1',
            'conditions.*.product_selector' => 'required|in:type,sku,vendor,price,qty',
            'conditions.*.operator'       => 'required|in:==,>,<',
            'conditions.*.value'          => 'required|string',
        ]);

        $rule->update([
            'name'       => $request->name,
            'apply_tags' => $request->apply_tags,
        ]);

        // Replace all old conditions
        $rule->conditions()->delete();
        foreach ($request->conditions as $condition) {
            $rule->conditions()->create($condition);
        }

        return redirect()->route('rules.index')
            ->with('success', 'Rule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule)
    {
        $rule->conditions()->delete();
        $rule->delete();

        return redirect()->route('rules.index')
            ->with('success', 'Rule deleted.');
    }

    /**
     * Apply a rule: match all conditions against every product.
     * If ALL conditions match a product, append the rule's tags to it.
     */
    public function applyRule(Rule $rule)
    {
        $rule->load('conditions');
        $products = Product::all();
        $appliedCount = 0;

        foreach ($products as $product) {
            $allMatch = true;

            foreach ($rule->conditions as $condition) {
                $field    = $condition->product_selector; // type, sku, vendor, price, qty
                $operator = $condition->operator;         // ==, >, <
                $value    = $condition->value;
                $actual   = $product->$field;

                $match = match ($operator) {
                    '=='    => strtolower((string)$actual) == strtolower($value),
                    '>'     => is_numeric($actual) && (float)$actual > (float)$value,
                    '<'     => is_numeric($actual) && (float)$actual < (float)$value,
                    default => false,
                };

                if (!$match) {
                    $allMatch = false;
                    break;
                }
            }

            if ($allMatch) {
                // Merge tags (avoid duplicates)
                $existingTags = $product->tags
                    ? array_map('trim', explode(',', $product->tags))
                    : [];

                $newTags = array_map('trim', explode(',', $rule->apply_tags));
                $merged  = array_unique(array_merge($existingTags, $newTags));
                $merged  = array_filter($merged); // remove empties

                $product->tags = implode(', ', $merged);
                $product->save();
                $appliedCount++;
            }
        }

        return redirect()->route('rules.index')
            ->with('success', "Rule applied. Tags added to {$appliedCount} product(s).");
    }
}