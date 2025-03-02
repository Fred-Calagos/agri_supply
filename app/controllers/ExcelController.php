<?php

namespace App\controllers;

use App\models\Order;
use App\Core\Database;
use App\Core\BaseController;
use App\models\ProductCategory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelController extends BaseController
{
    public function generateExcel()
    {
        $pdo = Database::connect();

        // Get filters from request
        $selectedCategory = $_GET['category'] ?? '';
        $selectedDate = $_GET['date'] ?? '';

        // Base query
        $sql = "SELECT po.*, 
                        p.product_name, p.image_path, p.shipping_fee, p.stocks, p.product_description, 
                        p.selling_price, p.cost_price, p.profit_margin, pc.product_category, os.order_status
                FROM product_ordered po
                JOIN products p ON po.product_id = p.id
                JOIN product_category pc ON p.product_category_id = pc.id
                JOIN order_status os ON po.order_status = os.id
                WHERE 1 = 1";

        // Apply filters
        $params = [];
        if ($selectedCategory) {
            $sql .= " AND pc.id = ?";
            $params[] = $selectedCategory;
        }
        if ($selectedDate) {
            $sql .= " AND YEAR(po.ordered_date) = ? AND MONTH(po.ordered_date) = ?";
            [$year, $month] = explode('-', $selectedDate);
            $params[] = $year;
            $params[] = $month;
        }

        $sql .= " ORDER BY po.ordered_date ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $orderReport = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $headers = [
            'No.', 'Track Number', 'Product Name', 'Category', 'Cost Price', 'Profit Margin', 
            'Unit Price', 'Quantity', 'Total Price', 'Profit', 'Status', 'Date'
        ];
        $sheet->fromArray($headers, NULL, 'A1');

        // Populate Data
        $row = 2;
        foreach ($orderReport as $index => $item) {
            $profit = ($item['selling_price'] - $item['cost_price']) * $item['product_quantity'];

            $sheet->fromArray([
                $index + 1,
                $item['order_track'],
                $item['product_name'],
                $item['product_category'],
                number_format($item['cost_price'], 2),
                number_format($item['profit_margin']) . '%',
                number_format($item['selling_price'], 2),
                $item['product_quantity'],
                number_format($item['selling_price'] * $item['product_quantity'], 2),
                number_format($profit, 2),
                $item['order_status'],
                date('F j, Y', strtotime($item['ordered_date']))
            ], NULL, 'A' . $row);

            $row++;
        }

        // Set response headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="OrderReport.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function generateSalesExcel()
    {
        $year = $_GET['year'] ?? null;
        $category = $_GET['category'] ?? null;
    
        $salesData = Order::getProductSales($year, $category); // Updated to support category
    
        $categoryName = $category ? ProductCategory::getCategoryName($category) : null;
    
        // Create Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Report title
        $title = 'Sales Report';
        if ($year) {
            $title .= " for $year";
        }
        if ($categoryName) {
            $title .= " (Category: $categoryName)";
        }
        $sheet->setCellValue('A1', $title);
        $sheet->mergeCells('A1:D1'); // Merge the title across columns
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
    
        // Header row
        $headers = ['No.', 'Product Name', 'Total Quantity Sold', 'Total Sales (₱)'];
        $sheet->fromArray($headers, NULL, 'A3');
    
        // Populate Data
        $row = 4;
        foreach ($salesData as $index => $item) {
            $sheet->fromArray([
                $index + 1,
                $item['product_name'],
                $item['total_quantity'],
                number_format($item['total_sales'], 2)
            ], NULL, 'A' . $row);
    
            $row++;
        }
    
        // Auto-size columns
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    
        // Set file name
        $fileName = "SalesReport";
        if ($year) {
            $fileName .= "_$year";
        }
        if ($categoryName) {
            $fileName .= "_category_" . strtolower(str_replace(' ', '_', $categoryName));
        }
        $fileName .= ".xlsx";
    
        // Set response headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header('Cache-Control: max-age=0');
    
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
    

}
