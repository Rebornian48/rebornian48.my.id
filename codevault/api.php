<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

define('DATA_FILE', __DIR__ . '/snippets_data.json');

function loadData() {
    if (!file_exists(DATA_FILE)) return [];
    $raw = file_get_contents(DATA_FILE);
    return json_decode($raw, true) ?: [];
}

function saveData($data) {
    file_put_contents(DATA_FILE, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

function respond($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$body   = json_decode(file_get_contents('php://input'), true) ?: [];
$id     = $_GET['id'] ?? null;

switch ($method) {
    // GET /api.php  — ambil semua snippet
    case 'GET':
        respond(loadData());

    // POST /api.php  — tambah snippet baru
    case 'POST':
        $nama   = trim($body['nama']   ?? '');
        $detail = trim($body['detail'] ?? '');
        $kode   = $body['kode']        ?? '';
        if (!$nama || !$detail || $kode === '') respond(['error' => 'nama, detail, kode wajib diisi'], 422);

        $data    = loadData();
        $snippet = [
            'id'        => 'snip_' . time() . '_' . rand(1000, 9999),
            'nama'      => $nama,
            'detail'    => $detail,
            'lang'      => trim($body['lang'] ?? ''),
            'tag'       => trim($body['tag']  ?? ''),
            'kode'      => $kode,
            'createdAt' => date('c'),
            'updatedAt' => date('c'),
        ];
        array_unshift($data, $snippet);
        saveData($data);
        respond($snippet, 201);

    // PUT /api.php?id=xxx  — edit snippet
    case 'PUT':
        if (!$id) respond(['error' => 'id diperlukan'], 400);
        $data = loadData();
        $idx  = array_search($id, array_column($data, 'id'));
        if ($idx === false) respond(['error' => 'snippet tidak ditemukan'], 404);

        $s = $data[$idx];
        $s['nama']      = trim($body['nama']   ?? $s['nama']);
        $s['detail']    = trim($body['detail'] ?? $s['detail']);
        $s['kode']      = $body['kode']        ?? $s['kode'];
        $s['lang']      = trim($body['lang']   ?? $s['lang']);
        $s['tag']       = trim($body['tag']    ?? $s['tag']);
        $s['updatedAt'] = date('c');
        $data[$idx]     = $s;
        saveData($data);
        respond($s);

    // DELETE /api.php?id=xxx  — hapus snippet
    case 'DELETE':
        if (!$id) respond(['error' => 'id diperlukan'], 400);
        $data    = loadData();
        $filtered = array_filter($data, fn($s) => $s['id'] !== $id);
        if (count($filtered) === count($data)) respond(['error' => 'snippet tidak ditemukan'], 404);
        saveData($filtered);
        respond(['success' => true]);

    default:
        respond(['error' => 'method tidak diizinkan'], 405);
}