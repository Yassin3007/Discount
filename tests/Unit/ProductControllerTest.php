<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testFetchProductsAndDiscountedPrices()
    {
        // Create test data
        $productA = Product::factory()->create(['name' => 'Product A', 'price' => 50.00]);
        $offerA = Offer::factory()->create(['discount' => 10, 'start_date' => Carbon::now()->subDays(1), 'end_date' => Carbon::now()->addDays(1), 'active' => true]);
        $productA->offers()->attach($offerA->id);

        $productB = Product::factory()->create(['name' => 'Product B', 'price' => 100.00]);
        $offerB = Offer::factory()->create(['discount' => 20, 'start_date' => Carbon::now()->subDays(1), 'end_date' => Carbon::now()->addDays(1), 'active' => true]);
        $productB->offers()->attach($offerB->id);

        $productC = Product::factory()->create(['name' => 'Product C', 'price' => 75.00]);

        // Run the code to be tested
        $response = $this->get('/products');

        // Assert response status
        $response->assertStatus(200);

        // Assert that the products and their discounted prices are present in the response
        $response->assertSeeText('Product A');
        $response->assertSeeText('Product B');
        $response->assertSeeText('Product C');
        $response->assertSeeText('45.00');
        $response->assertSeeText('80.00');
        $response->assertSeeText('75.00');
    }
}
