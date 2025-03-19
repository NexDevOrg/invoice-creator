<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name ?? 'Invoice' }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                line-height: 1.15;
                margin: 0;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            .header-table {
                width: 100%;
                padding: 1rem;
            }

            .header-right {
                text-align: right;
            }

            .invoice-title {
                font-size: 1.5rem;
                font-weight: 700;
                margin: 0;
                line-height: 2rem;
                color: rgb(55 65 81);
            }

            .invoice-meta {
                margin: 0;
                color: rgb(107 114 128);
            }

            .payment-details-title {
                font-weight: 700;
                color: rgb(55 65 81);
                margin-bottom: 0.75rem;
                font-size: 0.8rem;
            }

            .payment-details-text {
                margin: 0;
                color: rgb(107 114 128);
                font-size: 0.8rem;
                line-height: 1.5;
            }

            .company-table {
                width: 100%;
                margin-bottom: 2rem;
                padding: 1rem;
            }

            .company-name {
                font-size: 1rem;
                font-weight: 700;
                margin: 0;
                line-height: 2rem;
                color: rgb(55 65 81);
            }

            .company-details {
                margin: 0;
                color: rgb(107 114 128);
                font-size: 0.8rem;
            }

            .company-details-mt {
                margin-top: 0.7rem;
            }

            .items-table {
                width: 100%;
                margin-top: 1.5rem;
            }

            .items-table th {
                padding: 0.5rem 1rem;
                text-align: left;
                color: rgb(55 65 81);
                font-weight: 700;
                border-bottom: 1px solid rgb(229 231 235);
            }

            .items-table th.right {
                text-align: right;
            }

            .items-table td {
                padding: 0.5rem 1rem;
                color: rgb(107 114 128);
                border-bottom: 1px solid rgb(229 231 235);
            }

            .items-table td.right {
                text-align: right;
            }

            .totals-container {
                margin-top: 1.5rem;
            }
            
            .totals-table, .totals-table-container {
                width: 100%;
            }

            .totals-table td {
                padding: 0.5rem 1rem;
                color: rgb(107 114 128);
                border-bottom: 1px solid rgb(229 231 235);
            }

            .totals-table td.right {
                text-align: right;
            }

            .total-row {
                color: rgb(55 65 81);
                font-size: 1.025rem;
                line-height: 1.75rem;
                font-weight: 700;
            }

            .invoice-meta-table {
                width: 100%;
                text-align: right;
            }
        </style>
    </head>

    <body>
        <table class="header-table">
            <tr>
                <td>
                    @if ($invoice->logo)
                        <img src="{{ $invoice->logo }}" height="100">
                    @endif
                </td>
                <td class="header-right">
                    <h1 class="invoice-title">Invoice</h1>
                    <table class="invoice-meta-table">
                        <tr>
                            <td>
                                <p class="invoice-meta">Invoice number: #12345</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="invoice-meta">Date: March 18, 2025</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="invoice-meta">Due Date: April 18, 2025</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="company-table">
            <tr>
                <td>
                    <h1 class="company-name">NexDev</h1>
                </td>
                <td>
                    <h1 class="company-name">NOVA Agency</h1>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <p class="company-details">Cycladenlaan 102</p>
                    <p class="company-details">1060LZ Amsterdam</p>
                    <p class="company-details">The Netherlands</p>
                    <p class="company-details company-details-mt">KvK nr: 96461527</p>
                    <p class="company-details">BTW nr: NL867621424B01</p>
                    <p class="company-details company-details-mt">E-mail: nexdev.software@gmail.com</p>
                </td>
                <td style="vertical-align: top;">
                    <p class="company-details">32 Kinburn Street</p>
                    <p class="company-details">SE16 6DW London</p>
                    <p class="company-details">United Kingdom</p>
                </td>
            </tr>
        </table>

        <div class="totals-container">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th class="right">Quantity</th>
                        <th class="right">Price</th>
                        <th class="right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Web Development</td>
                        <td class="right">1</td>
                        <td class="right">$1000</td>
                        <td class="right">$1000</td>
                    </tr>
                    <tr>
                        <td>Hosting</td>
                        <td class="right">1</td>
                        <td class="right">$200</td>
                        <td class="right">$200</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="totals-container">
            <table class="totals-table-container">
                <tr>
                    <td style="width: 100%;">
                        <div class="payment-details">
                            <p class="payment-details-title">Payment Details</p>
                            <p class="payment-details-text">Bank: ING Bank</p>
                            <p class="payment-details-text">Account Name: NexDev</p>
                            <p class="payment-details-text">IBAN: NL91ABNA0417164300</p>
                            <p class="payment-details-text">BIC: ABNANL2A</p>
                        </div>
                    </td>
                    <td style="width: 300px;">
                        <table class="totals-table">
                            <tr>
                                <td>Subtotal:</td>
                                <td class="right">$1200</td>
                            </tr>
                            <tr>
                                <td>Tax (10%):</td>
                                <td class="right">$120</td>
                            </tr>
                            <tr>
                                <td class="total-row">Total:</td>
                                <td class="right total-row">$1320</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>