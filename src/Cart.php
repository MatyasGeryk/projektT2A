<?php
declare(strict_types=1);

class Cart
{
    public static function addItem(int $productId, int $quantity, ?string $size = null, ?string $color = null): void
    {
        $key = self::generateKey($productId, $size, $color);
        
        if (isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$key] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'size' => $size,
                'color' => $color,
            ];
        }
    }
    
    public static function removeItem(string $key): void
    {
        unset($_SESSION['cart'][$key]);
    }
    
    public static function updateQuantity(string $key, int $quantity): void
    {
        if ($quantity > 0 && isset($_SESSION['cart'][$key])) {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
        }
    }
    
    public static function getCart(): array
    {
        return $_SESSION['cart'] ?? [];
    }
    
    public static function isEmpty(): bool
    {
        return empty($_SESSION['cart']);
    }
    
    public static function getItemCount(): int
    {
        $count = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }
    
    public static function clear(): void
    {
        $_SESSION['cart'] = [];
    }
    
    private static function generateKey(int $productId, ?string $size, ?string $color): string
    {
        return "{$productId}_" . ($size ?? 'none') . "_" . ($color ?? 'none');
    }
}
?>
