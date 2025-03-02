<?php

namespace App\controllers;

use TCPDF;
use App\models\Brand;
use App\models\Order;
use App\Core\Database;
use App\Core\BaseController;
use App\models\ProductCategory;

class PdfController extends BaseController{
    public function generateOrderPdf() {
        if (!isset($_GET['track'])) {
            die("Order Track Number is required.");
        }

        $trackNumber = $_GET['track']; // Get track number from URL

        $orderTracks =Order::getAllOrdersByTrack($trackNumber); // Fetch orders by track number

        if (empty($orderTracks)) {
            die("No orders found for Track #: " . htmlspecialchars($trackNumber));
        }

        // Create PDF instance
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetFont('dejavusans', '', 10); // Use DejaVuSans for Unicode support

        $pdf->SetTitle('Order Summary - ' . $trackNumber);
        $pdf->AddPage();

        // PDF Header
        $html = '<h2 style="text-align:center;">Order Summary</h2>';
        $html .= '
        <h4>Order Track #: ' . htmlspecialchars($trackNumber) . '</h4>
        ';
        $html .= '<table border="1" cellpadding="5">
                    <thead>
                        <tr style="background-color:#f2f2f2;">
                            <th>Product Name</th>
                            <th>Unit Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>';

        // Loop through order items
        foreach ($orderTracks as $item) {
            $total_price = $item['selling_price'] * $item['product_quantity'];
            $html .= "<tr>
                        <td>{$item['product_name']}</td>
                        <td>₱ " . number_format($item['selling_price'], 2) . "</td>
                        <td>{$item['product_quantity']}</td>
                        <td>₱ " . number_format($total_price, 2) . "</td>
                      </tr>";
        }

        $html .= '</tbody></table>';

        // Output PDF
        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('order_' . $trackNumber . '.pdf', 'D'); // Download PDF
    }

    public function viewPdfReport() {
        if (!isset($_GET['track'])) {
            die("Order Track Number is required.");
        }

        $trackNumber = $_GET['track']; // Get track number from URL

        $orderTracks = Order::getAllOrdersByTrack($trackNumber); // Fetch orders by track number
       

        if (empty($orderTracks)) {
            die("No orders found for Track #: " . htmlspecialchars($trackNumber));
        }
        $brand = Brand::displayBrandReceipt();

        if ($brand) {
            $storeName = $brand['brand_name'];
            $storeContact = $brand['contact'];
            $storeEmail = $brand['email'];
        } else {
            $storeName = "Default Store Name";
            $storeContact = "N/A";
            $storeEmail = "N/A";
        }
        

        // Order Information
        $orderTrack = htmlspecialchars($trackNumber);
        $orderDate = date("Y-m-d"); // Example date


                // Generate PDF
        $pdf = new TCPDF('P', 'mm', 'A6', true, 'UTF-8', false);
        
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setMargins(5,5,5);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->SetTitle('Order Summary - ' . $trackNumber);
        
        $pdf->AddPage();
        // Add Store Logo (Adjust path & position as needed)
        $pdf->Image('brand_images/logo.jpg', 5, 5, 10, 10, 'JPG');
        $pdf->Ln(10);
        // Set column width (50% each)
        $colWidth = 48; // A6 width = 105mm, keeping margin space
        // Store Details (Left Column)
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell($colWidth, 5, $storeName, 0, 0, 'L'); // Name
        $pdf->Cell($colWidth, 5, "Order Details", 0, 1, 'L'); // Header
        $pdf->SetFont('dejavusans', '', 7);
        $pdf->Cell($colWidth, 5, "Contact: " . $storeContact, 0, 0, 'L'); // Contact
        $pdf->Cell($colWidth, 5, "Order #: " . $orderTrack, 0, 1, 'L'); // Order Track #
        $pdf->Cell($colWidth, 5, "Email: " . $storeEmail, 0, 0, 'L'); // Email
        $pdf->Cell($colWidth, 5, "Date: " . $orderDate, 0, 1, 'L'); // Order Date
        $pdf->Ln();
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell($colWidth, 5, "Invoice To:", 0, 1, 'L'); // Name
        $pdf->SetFont('dejavusans', '', 7);

        if (!empty($orderTracks)) {
            $customerName = $orderTracks[0]['fullName'];
            $customerprov = $orderTracks[0]['prov'];
            $customercitymun = $orderTracks[0]['citymun'];
            $customerbrgy = $orderTracks[0]['brgy'];
            $customerEmail = $orderTracks[0]['email'];
            $shippingFee =  $orderTracks[0]['shipping_fee']; 
        } else {
            $customerName = "N/A";
            $customerAddress = "N/A";
            $customerEmail = "N/A";
        }

        $pdf->Cell($colWidth, 5, "Name: " . $customerName, 0, 1, 'L');
        $pdf->Cell($colWidth, 5, "Address: " . $customerbrgy . ', ' . $customercitymun . ', ' . $customerprov , 0, 1, 'L');
        $pdf->Cell($colWidth, 5, "Email: " . $customerEmail, 0, 1, 'L');

        $pdf->Ln(5); // Space after header

        // Table Header
        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->SetFillColor(230, 230, 230); // Light gray background

        $pdf->Cell(30, 8, 'Product Name', 1, 0, 'C', true);
        $pdf->Cell(18, 8, 'Unit Price', 1, 0, 'C', true);
        $pdf->Cell(24, 8, 'Quantity', 1, 0, 'C', true);
        $pdf->Cell(24, 8, 'Total Price', 1, 1, 'C', true);

        // Table Body
        $pdf->SetFont('dejavusans', '', 7);
        $subTotal = 0;

        foreach ($orderTracks as $item) {
            $total_price = $item['selling_price'] * $item['product_quantity'];
            $subTotal += $total_price;

            $pdf->Cell(30, 6, $item["product_name"], 1);
            $pdf->Cell(18, 6, '₱ ' . number_format($item["selling_price"], 2), 1, 0, 'R');
            $pdf->Cell(24, 6, $item['product_quantity'], 1, 0, 'C');
            $pdf->Cell(24, 6, '₱ ' . number_format($total_price, 2), 1, 1, 'R');
        }

        // Footer Totals

        $grandTotal = $subTotal + $shippingFee;

        $pdf->SetFont('dejavusans', 'B', 7);
        $pdf->Cell(72, 6, 'Sub Total:', 1, 0, 'R', true);
        $pdf->Cell(24, 6, '₱ ' . number_format($subTotal, 2), 1, 1, 'R');

        $pdf->Cell(72, 6, 'Shipping Fee:', 1, 0, 'R', true);
        $pdf->Cell(24, 6, '₱ ' . number_format($shippingFee, 2), 1, 1, 'R');

        $pdf->Cell(72, 6, 'Grand Total:', 1, 0, 'R', true);
        $pdf->Cell(24, 6, '₱ ' . number_format($grandTotal, 2), 1, 1, 'R');

        // Footer Message
        $pdf->Ln(1);
        $pdf->SetFont('dejavusans', '', 8);
        $pdf->Cell(0, 5, 'Thank you for your purchase!', 0, 1, 'C');
        $pdf->Cell(0, 5, 'For any inquiries, contact us at ' . $storeEmail, 0, 1, 'C');

        // Output PDF file
        $pdf->Output('order_' . $trackNumber . '.pdf', 'I'); // Show PDF in browser

    }


    public function viewSalesPdfReport() {
        $year = isset($_GET['year']) ? $_GET['year'] : null;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
    
        $productSales = Order::getProductSales($year, $category);

        $categoryName = $category ? ProductCategory::getCategoryName($category) : null;

    
        // Check if there are sales to display
        $bestProduct = !empty($productSales) ? $productSales[0] : null;
        $leastProduct = !empty($productSales) ? $productSales[array_key_last($productSales)] : null;
    
        if (empty($productSales)) {
            $noDataMessage = "No sales data found";
            if ($year) $noDataMessage .= " for year $year";
            if ($category) $noDataMessage .= ($year ? " and" : " for") . " selected category.";
            $noDataMessage .= ".";
            die($noDataMessage);
        }
    
        $reportTitle = "Sales Report";
        if ($year) $reportTitle .= " for $year";
        if ($category) $reportTitle .= " $categoryName";
    
        // Create PDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($reportTitle);
        $pdf->setMargins(10, 10, 10);
        $pdf->SetFont('dejavusans', '', 10);
        $pdf->AddPage();
    
        // Report Header
        $pdf->SetFont('dejavusans', 'B', 14);
        $pdf->Cell(0, 10, $reportTitle, 0, 1, 'C');
    
        $pdf->Ln(5);
    
        // Table Header
        $pdf->SetFont('dejavusans', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(15, 8, 'No.', 1, 0, 'C', true);
        $pdf->Cell(80, 8, 'Product Name', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Total Quantity Sold', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Total Sales (₱)', 1, 1, 'C', true);
    
        // Table Body
        $pdf->SetFont('dejavusans', '', 10);
    
        $totalProducts = count($productSales);
        $totalQuantity = 0;
        $totalSales = 0;
    
        foreach ($productSales as $index => $item) {
            $totalQuantity += $item['total_quantity'];
            $totalSales += $item['total_sales'];
    
            $pdf->Cell(15, 8, $index + 1, 1, 0, 'C');
            $pdf->Cell(80, 8, $item['product_name'], 1);
            $pdf->Cell(40, 8, number_format($item['total_quantity']), 1, 0, 'C');
            $pdf->Cell(50, 8, '₱ ' . number_format($item['total_sales'], 2), 1, 1, 'R');
        }
    
        $pdf->Ln(5);
    
        // Totals Table
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->SetFillColor(230, 230, 230);
    
        $pdf->Cell(50, 8, 'Total Products:', 1, 0, 'L', true);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->Cell(50, 8, $totalProducts, 1, 1, 'R');
    
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(50, 8, 'Total Quantity:', 1, 0, 'L', true);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->Cell(50, 8, number_format($totalQuantity), 1, 1, 'R');
    
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(50, 8, 'Total Sales:', 1, 0, 'L', true);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->Cell(50, 8, '₱ ' . number_format($totalSales, 2), 1, 1, 'R');
    
        $pdf->Ln(5);
    
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(100, 8, 'Best and Least Selling Products', 1, 1, 'C', true);
    
        $pdf->SetFont('dejavusans', 'B', 9);
        $pdf->Cell(50, 8, 'Category', 1, 0, 'C', true);
        $pdf->Cell(50, 8, 'Product Name', 1, 1, 'C', true);
    
        if ($bestProduct) {
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(50, 8, 'Best Seller', 1, 0, 'L');
            $pdf->Cell(50, 8, $bestProduct['product_name'], 1, 1, 'L');
        }
    
        if ($leastProduct) {
            $pdf->SetFont('dejavusans', '', 9);
            $pdf->Cell(50, 8, 'Least Seller', 1, 0, 'L');
            $pdf->Cell(50, 8, $leastProduct['product_name'], 1, 1, 'L');
        }
    
        $pdf->Ln(5);
        $pdf->SetFont('dejavusans', '', 9);
        $pdf->Cell(0, 5, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 1, 'R');
    
        $fileName = "sales_report";
        if ($year) $fileName .= "_$year";
        if ($category) $fileName .= "_category_$category";
        $fileName .= ".pdf";
    
        $pdf->Output($fileName, 'I');
    }
    
    
}
