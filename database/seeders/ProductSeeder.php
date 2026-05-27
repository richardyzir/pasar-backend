    <?php

    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use App\Models\Product;

    class ProductSeeder extends Seeder
    {
        public function run()
        {
            $products = [
                ['name' => 'Beras Premium 5kg', 'description' => 'Beras premium kualitas terbaik, pulen dan wangi', 'price' => 75000, 'stock' => 37, 'category' => 'Sembako'],
                ['name' => 'Minyak Goreng 2L', 'description' => 'Minyak goreng kemasan 2 liter', 'price' => 35000, 'stock' => 69, 'category' => 'Sembako'],
                ['name' => 'Gula Pasir 1kg', 'description' => 'Gula pasir putih premium', 'price' => 15000, 'stock' => 186, 'category' => 'Sembako'],
                ['name' => 'Telur Ayam 1kg', 'description' => 'Telur ayam segar negeri', 'price' => 28000, 'stock' => 69, 'category' => 'Segar'],
                ['name' => 'Indomie Goreng 1 Dus', 'description' => 'Mie instan goreng isi 40 pcs', 'price' => 50000, 'stock' => 149, 'category' => 'Makanan'],
                ['name' => 'Kopi Sachet 1 Renteng', 'description' => 'Kopi instan sachet isi 10', 'price' => 12000, 'stock' => 292, 'category' => 'Minuman'],
                ['name' => 'Sabun Mandi Lifebuoy', 'description' => 'Sabun mandi batang isi 3', 'price' => 8000, 'stock' => 248, 'category' => 'Perawatan'],
                ['name' => 'Deterjen Rinso 1kg', 'description' => 'Deterjen bubuk wangi segar', 'price' => 18000, 'stock' => 119, 'category' => 'Rumah Tangga'],
                ['name' => 'Kangkung', 'description' => 'Kangkung segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Sawi', 'description' => 'Sawi segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Bayam', 'description' => 'Bayam segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Sop (Paketan)', 'description' => 'Paketan sop (bundle)', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Tomat', 'description' => 'Tomat segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Lombok', 'description' => 'Lombok segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Bawang Merah', 'description' => 'Bawang merah segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Bawang Putih', 'description' => 'Bawang putih segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Jagung', 'description' => 'Jagung segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Wortel', 'description' => 'Wortel segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Kentang', 'description' => 'Kentang segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Tempe', 'description' => 'Tempe segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Tahu', 'description' => 'Tahu segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Terong', 'description' => 'Terong segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Daun Singkong', 'description' => 'Daun singkong segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Kacang Panjang', 'description' => 'Kacang panjang segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Labu Siam', 'description' => 'Labu siam segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Pare', 'description' => 'Pare segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Kecambah', 'description' => 'Kecambah segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Kembang Kol', 'description' => 'Kembang kol segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Timun', 'description' => 'Timun segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Kol', 'description' => 'Kol segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Kelapa', 'description' => 'Kelapa segar', 'price' => 5000, 'stock' => 10, 'category' => 'Sayur'],
                ['name' => 'Ikan Layang', 'description' => 'Ikan layang segar', 'price' => 5000, 'stock' => 10, 'category' => 'Ikan'],
                ['name' => 'Ikan Tongkol', 'description' => 'Ikan tongkol segar', 'price' => 5000, 'stock' => 10, 'category' => 'Ikan'],
                ['name' => 'Biji Nangka', 'description' => 'Biji nangka segar', 'price' => 5000, 'stock' => 10, 'category' => 'Ikan'],
                ['name' => 'Ikan Kakap', 'description' => 'Ikan kakap segar', 'price' => 5000, 'stock' => 10, 'category' => 'Ikan'],
                ['name' => 'Udang', 'description' => 'Udang segar', 'price' => 5000, 'stock' => 10, 'category' => 'Ikan'],
                ['name' => 'Cumi', 'description' => 'Cumi segar', 'price' => 5000, 'stock' => 10, 'category' => 'Ikan'],
                ['name' => 'Ayam', 'description' => 'Ayam segar', 'price' => 5000, 'stock' => 10, 'category' => 'Daging'],
                ['name' => 'Telor', 'description' => 'Telor segar', 'price' => 5000, 'stock' => 10, 'category' => 'Daging'],
                ['name' => 'Daging', 'description' => 'Daging segar', 'price' => 5000, 'stock' => 10, 'category' => 'Daging'],
                ['name' => 'Asam', 'description' => 'Asam segar', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Garam', 'description' => 'Garam', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Merica', 'description' => 'Merica', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Gula Merah', 'description' => 'Gula merah', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Ketumbar', 'description' => 'Ketumbar', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Penyedap Rasa', 'description' => 'Penyedap rasa', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Micin', 'description' => 'Micin', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Tepung Bumbu', 'description' => 'Tepung bumbu', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Bumbu Racik', 'description' => 'Bumbu racik', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Tepung Terigu', 'description' => 'Tepung terigu', 'price' => 5000, 'stock' => 10, 'category' => 'Bumbu'],
                ['name' => 'Pisang', 'description' => '1 sisir', 'price' => 5000, 'stock' => 10, 'category' => 'Buah'],
                ['name' => 'Singkong', 'description' => 'Singkong siap masak', 'price' => 5000, 'stock' => 10, 'category' => 'Buah'],
                ['name' => 'Ubi Jalar', 'description' => 'Ubi siap masak', 'price' => 5000, 'stock' => 10, 'category' => 'Buah'],
                ['name' => 'Nanas', 'description' => 'Nanas segar 1 buah', 'price' => 5000, 'stock' => 10, 'category' => 'Buah'],
                ['name' => 'Pepaya', 'description' => 'Pepaya segar 1 buah', 'price' => 5000, 'stock' => 10, 'category' => 'Buah'],
                ['name' => 'Semangka', 'description' => 'Semangka segar 1 buah', 'price' => 5000, 'stock' => 10, 'category' => 'Buah'],
            ];

            foreach ($products as $product) {
                Product::create($product);
            }
        }
    }
