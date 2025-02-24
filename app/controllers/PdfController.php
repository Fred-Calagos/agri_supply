<?php

namespace App\controllers;

use App\Core\BaseController;
use App\models\Order;
use TCPDF;

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
// Store Information
$storeName = "Agri Supply Store"; 
$storeAddress = "123 Farm Road, City, Country";
$storeContact = "+63 912 345 6789";
$storeEmail = "contact@agrisupply.com";

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

// Set column width (50% each)
$colWidth = 48; // A6 width = 105mm, keeping margin space

// Store Details (Left Column)
$pdf->SetFont('dejavusans', 'B', 7);
$pdf->Cell($colWidth, 5, $storeName, 0, 0, 'L'); // Name
$pdf->SetFont('dejavusans', '', 7);
$pdf->Ln(); // Move to next line
$pdf->Cell($colWidth, 5, $storeAddress, 0, 0, 'L'); // Address
$pdf->Ln();
$pdf->Cell($colWidth, 5, "Contact: " . $storeContact, 0, 0, 'L'); // Contact
$pdf->Ln();
$pdf->Cell($colWidth, 5, "Email: " . $storeEmail, 0, 0, 'L'); // Email

// Move cursor to next column (Order Details)
$pdf->SetXY($colWidth + 10, 15); // Adjust position

// Order Details (Right Column)
$pdf->SetFont('dejavusans', 'B', 7);
$pdf->Cell($colWidth, 5, "Order Details", 0, 1, 'L'); // Header
$pdf->SetFont('dejavusans', '', 7);
$pdf->Cell($colWidth, 5, "Order #: " . $orderTrack, 0, 1, 'L'); // Order Track #
$pdf->Cell($colWidth, 5, "Date: " . $orderDate, 0, 1, 'L'); // Order Date

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
$shippingFee = 50; 
$grandTotal = $subTotal + $shippingFee;

$pdf->SetFont('dejavusans', 'B', 7);
$pdf->Cell(72, 6, 'Sub Total:', 1, 0, 'R', true);
$pdf->Cell(24, 6, '₱ ' . number_format($subTotal, 2), 1, 1, 'R');

$pdf->Cell(72, 6, 'Shipping Fee:', 1, 0, 'R', true);
$pdf->Cell(24, 6, '₱ ' . number_format($shippingFee, 2), 1, 1, 'R');

$pdf->Cell(72, 6, 'Grand Total:', 1, 0, 'R', true);
$pdf->Cell(24, 6, '₱ ' . number_format($grandTotal, 2), 1, 1, 'R');

// Footer Message
$pdf->Ln(10);
$pdf->SetFont('dejavusans', '', 8);
$pdf->Cell(0, 10, 'Thank you for your purchase!', 0, 1, 'C');
$pdf->Cell(0, 5, 'For any inquiries, contact us at ' . $storeEmail, 0, 1, 'C');

// Output PDF file
$pdf->Output('order_' . $trackNumber . '.pdf', 'I'); // Show PDF in browser

    }
}
