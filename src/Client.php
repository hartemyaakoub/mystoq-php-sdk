<?php
declare(strict_types=1);

namespace Mystoq;

/**
 * Mystoq PHP SDK - https://mystoq.com
 */
final class Client
{
    private string $apiKey;
    private ?string $tenant;
    private string $baseUrl;

    public function __construct(
        string $apiKey,
        ?string $tenant = null,
        string $baseUrl = "https://api.mystoq.com/v1"
    ) {
        if ($apiKey === "") {
            throw new \InvalidArgumentException("apiKey is required");
        }
        $this->apiKey  = $apiKey;
        $this->tenant  = $tenant;
        $this->baseUrl = rtrim($baseUrl, "/");
    }

    public function listProducts(array $params = []): array
    {
        return $this->request("GET", "/products" . (empty($params) ? "" : "?" . http_build_query($params)));
    }

    public function getProduct(string $id): array
    {
        return $this->request("GET", "/products/" . rawurlencode($id));
    }

    public function createOrder(array $data): array
    {
        return $this->request("POST", "/orders", $data);
    }

    public function listWilayas(): array
    {
        return $this->request("GET", "/wilayas");
    }

    private function request(string $method, string $path, ?array $body = null): array
    {
        $ch = curl_init($this->baseUrl . $path);
        $headers = [
            "Authorization: Bearer " . $this->apiKey,
            "Accept: application/json",
            "Content-Type: application/json",
        ];
        if ($this->tenant !== null) {
            $headers[] = "X-Tenant-ID: " . $this->tenant;
        }
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => 30,
        ]);
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE));
        }
        $raw    = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $err    = curl_error($ch);
        curl_close($ch);
        if ($raw === false) {
            throw new \RuntimeException("Mystoq SDK transport error: $err");
        }
        $decoded = json_decode((string) $raw, true);
        if ($status >= 400) {
            throw new \RuntimeException("Mystoq API $status: " . substr((string) $raw, 0, 500));
        }
        return is_array($decoded) ? $decoded : [];
    }
}
