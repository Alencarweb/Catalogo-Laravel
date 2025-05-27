<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AutomotiveSpecification;
use Illuminate\Http\Request;

class AutomotiveSpecificationController extends Controller
{
    public function list($productId)
    {
        // $all = AutomotiveSpecification::select('specification')->distinct()->get()->pluck('specification');
        $all = AutomotiveSpecification::select('specification')->distinct()->get()->pluck('specification');

        $selected = AutomotiveSpecification::where('product_id', $productId)->pluck('specification');

        return response()->json([
            'all' => $all,
            'selected' => $selected
        ]);
    }
    
    public function toggle(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'specification' => 'required|string',
            'checked' => 'sometimes|boolean',
        ]);
    
        $productId = $validated['product_id'];
        $spec = $validated['specification'];
        $isChecked = $validated['checked'] ?? true;
    
        if ($isChecked) {
            DB::table('automotive_specifications')->updateOrInsert(
                ['product_id' => $productId, 'specification' => $spec],
                ['updated_at' => now()]
            );
        } else {
            $alreadyExistsFree = DB::table('automotive_specifications')
                ->where('product_id', 0)
                ->where('specification', $spec)
                ->exists();
        
            if ($alreadyExistsFree) {
                DB::table('automotive_specifications')
                    ->where('product_id', $productId)
                    ->where('specification', $spec)
                    ->delete(); 
            } else {
                DB::table('automotive_specifications')
                    ->where('product_id', $productId)
                    ->where('specification', $spec)
                    ->update(['product_id' => 0, 'updated_at' => now()]);
            }
        }
        
    
        return response()->json(['success' => true]);
    }
    
    
    

    // public function show($productId)
    // {
    //     $allSpecs = AutomotiveSpecification::select('specification')->pluck('specification')->unique()->values();

    //     $selectedSpecs = AutomotiveSpecification::where('product_id', $productId)
    //         ->pluck('specification');

    //     return response()->json([
    //         'all' => $allSpecs,
    //         'selected' => $selectedSpecs
    //     ]);
    // }

}
