@extends('layout.index')
@section('title', 'List Transaction')

@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Transaction List</h4>
                <h6>Manage your transaction</h6>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a><img src="{{ asset('assets/img/icons/pdf.svg') }}" alt="img"></a>
            </li>
            <li>
                <a><img src="{{ asset('assets/img/icons/excel.svg') }}" alt="img"></a>
            </li>
            <li>
                <a href="{{ url()->current() }}"><i class="ti ti-refresh"></i></a>
            </li>
        </ul>
        <div class="page-btn">
            <a href="{{ route('pos.index') }}" class="btn btn-primary">
                <i class="ti ti-circle-plus me-1"></i>
                Create Transaction
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ url()->current() }}" method="GET">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label">Invoice</label>
                                <input type="text" class="form-control" name="invoice" value="{{ request()->get('invoice', null) }}" placeholder="Invoice number ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Order Number</label>
                                <input type="number" class="form-control" name="orderNumber" value="{{ request()->get('orderNumber', null) }}" placeholder="Order number ...">
                            </div>
                            <div class="col-2">
                                <label class="form-label">Payment Method</label>
                                <select class="form-control" name="paymentMethod">
                                    <option value="">-- Choose Payment Method --</option>
                                    <option {{ request()->get('paymentMethod') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option {{ request()->get('paymentMethod') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                    <option {{ request()->get('paymentMethod') == 'Debit' ? 'selected' : '' }}>Debit</option>
                                    <option {{ request()->get('paymentMethod') == 'Transfer' ? 'selected' : '' }}>Transfer</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Payment Status</label>
                                <select class="form-control" name="paymentStatus">
                                    <option value="">-- Choose Payment Status --</option>
                                    <option value="paid" {{ request()->get('paymentStatus') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="pending" {{ request()->get('paymentStatus') == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Transaction Date</label>
                                <input type="date" class="form-control" name="date" value="{{ request()->get('date', null) }}">
                            </div>
                            <div class="col-2">
                                <label class="form-label text-white">-</label>
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                    <a href="{{ url()->current() }}" class="btn btn-danger">Clear</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice</th>
                                    <th class="text-center">Order No</th>
                                    <th class="text-center">QTY Item</th>
                                    <th>Total Price</th>
                                    <th class="text-center">Payment Method</th>
                                    <th class="text-center">Payment Status</th>
                                    <th class="text-center">Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction as $index => $item)
                                <tr>
                                    <td>{{ $transaction->firstItem() + $index }}</td>
                                    <td><a href="{{ route('transaction.detail', ['invoice' => $item->invoice_number]) }}" class="text-blue-400">{{ $item->invoice_number }}</a></td>
                                    <td class="text-center">{{ $item->order_number }}</td>
                                    <td class="text-center">{{ number_format($item->qty) }}</td>
                                    <td>Rp {{ number_format($item->total) }}</td>
                                    <td class="text-center">{{ $item->paymentMethod->name }}</td>
                                    <td class="text-center">
                                        @if($item->payment_status == 'pending')
                                            <span class="badge bg-danger">Unpaid</span>
                                        @elseif($item->payment_status == 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($item->transaction_status == 'canceled')
                                            <span class="badge bg-danger">Canceled</span>
                                        @else
                                            <span class="badge bg-success">Completed</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->transaction_date)->translatedFormat('d F Y H:i') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('transaction.detail', ['invoice' => $item->invoice_number]) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a class="btn btn-primary btn-sm" onclick="printNota('{{ $item->invoice_number }}')">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            @if($item->payment_status == 'pending')
                                                <a class="btn btn-secondary btn-sm" onclick="changeStatusPayment('{{ $item->invoice_number }}')">
                                                    <i class="fa-solid fa-credit-card"></i>
                                                </a>
                                            @endif
                                            @if($item->transaction_status == 'normal')
                                                <a class="btn btn-danger btn-sm" onclick="cancelTransaction('{{ $item->invoice_number }}')">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        @if ($transaction->hasPages())
                            <ul class="pagination">
                                @if ($transaction->onFirstPage())
                                    <li class="disabled"><span>&laquo; Previous</span></li>
                                @else
                                    <li><a href="{{ $transaction->previousPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="prev">&laquo; Previous</a></li>
                                @endif

                                @foreach ($transaction->links()->elements as $element)
                                    @if (is_string($element))
                                        <li class="disabled"><span>{{ $element }}</span></li>
                                    @endif

                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            @if ($page == $transaction->currentPage())
                                                <li class="active"><span>{{ $page }}</span></li>
                                            @else
                                                <li><a href="{{ $url }}&per_page={{ request('per_page', 10) }}">{{ $page }}</a></li>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach

                                @if ($transaction->hasMorePages())
                                    <li><a href="{{ $transaction->nextPageUrl() }}&per_page={{ request('per_page', 10) }}" rel="next">Next &raquo;</a></li>
                                @else
                                    <li class="disabled"><span>Next &raquo;</span></li>
                                @endif
                            </ul>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="printNotaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" id="buttonPrintNota">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/qz-tray/qz-tray.js"></script>
    <script>
        localStorage.setItem('print_kasir', JSON.stringify('POS-58-KASIR'));
        localStorage.setItem('print_dapur', JSON.stringify('POS-58-DAPUR'));

        function printNota(invoiceNumber) {
            document.getElementById('buttonPrintNota').innerHTML = `
                <div class="col-6">
                    <a class="btn btn-info w-100" onclick="printInvoicePOS('${invoiceNumber}')">Print POS</a>
                </div>
                <div class="col-6">
                    <a class="btn btn-secondary w-100" onclick="printNotaKitchen('${invoiceNumber}')">Print Kitchen</a>
                </div>
            `;

            $('#printNotaModal').modal('show');
        }

        function cancelTransaction(invoiceNumber) {
            Swal.fire({
                title: "Are you sure?",
                text: `Cancel Transaction ${invoiceNumber} ?`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Cancel!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('transaction.cancel') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            invoiceNumber: invoiceNumber,
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success',
                                    text: `Cancel Transaction ${invoiceNumber} Successfully!`,
                                    icon: "success",
                                }).then((i) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Failed',
                                    text: `Cancel Transaction ${invoiceNumber} Failed!`,
                                    icon: "error",
                                });
                            }
                        }
                    });

                }
            });
        }

        function changeStatusPayment(invoiceNumber) {
            Swal.fire({
                title: "Are you sure?",
                text: `Change Status Payment Invoice ${invoiceNumber} ?`,
                icon: "warning",
                showCancelButton: true,
                customClass: {
                    confirmButton: "btn btn-primary w-xs me-2 mt-2",
                    cancelButton: "btn btn-danger w-xs mt-2"
                },
                confirmButtonText: "Yes, Change!",
                buttonsStyling: false,
                showCloseButton: true
            }).then((i) => {
                if (i.value) {

                    $.ajax({
                        url: '{{ route('transaction.change.status.payment') }}',
                        method: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            invoiceNumber: invoiceNumber,
                        },
                        success: (res) => {
                            if (res.status) {
                                Swal.fire({
                                    title: 'Success',
                                    text: `Change Status Payment Invoice ${invoiceNumber} Successfully!`,
                                    icon: "success",
                                }).then((i) => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Failed',
                                    text: `Change Status Payment Invoice ${invoiceNumber} Failed!`,
                                    icon: "error",
                                });
                            }
                        }
                    });

                }
            });
        }

        // HAPUS semua kode certificate lama, ganti dengan ini:

        qz.security.setCertificatePromise(function(resolve, reject) {
            fetch('/qz/digital-certificate.txt')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Certificate not found: ' + response.status);
                    }
                    return response.text();
                })
                .then(certificate => {
                    // Validate format
                    if (!certificate.includes('-----BEGIN CERTIFICATE-----')) {
                        throw new Error('Invalid certificate format');
                    }

                    console.log('✓ Certificate loaded');
                    console.log('Certificate size:', certificate.length, 'chars');
                    console.log('Preview:', certificate.substring(0, 60) + '...');

                    resolve(certificate);
                })
                .catch(error => {
                    console.error('✗ Certificate error:', error);
                    reject(error);
                });
        });

        qz.security.setSignaturePromise(function(toSign) {
            return function(resolve, reject) {
                console.log('→ Requesting signature...');
                console.log('Data to sign (preview):', toSign.substring(0, 50) + '...');

                fetch('/sign', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'text/plain'
                    },
                    body: toSign
                })
                    .then(response => {
                        console.log('Sign response status:', response.status);

                        if (!response.ok) {
                            return response.text().then(text => {
                                throw new Error('Sign failed: ' + response.status + ' - ' + text);
                            });
                        }

                        return response.text();
                    })
                    .then(signature => {
                        console.log('✓ Signature received');
                        console.log('Signature size:', signature.length, 'chars');
                        console.log('Preview:', signature.substring(0, 50) + '...');

                        // Validate base64
                        if (!/^[A-Za-z0-9+/=]+$/.test(signature)) {
                            throw new Error('Invalid signature format (not base64)');
                        }

                        resolve(signature);
                    })
                    .catch(error => {
                        console.error('✗ Signature error:', error);
                        reject(error);
                    });
            };
        });

        function connectQZ() {
            if (!qz.websocket.isActive()) {
                console.log('→ Connecting to QZ Tray...');
                return qz.websocket.connect()
                    .then(() => {
                        console.log('✓ QZ Tray connected');
                    })
                    .catch(err => {
                        console.error('✗ QZ connect error:', err);
                        alert("QZ Tray belum jalan. Pastikan QZ Tray sudah dijalankan.");
                        throw err;
                    });
            }
            return Promise.resolve();
        }

        const PRINTER_POS = "PRINT_KASIR";

        function printInvoicePOS(invoiceNumber) {
            $.ajax({
                url: '{{ route('pos.find.transaction') }}',
                method: 'GET',
                data: {
                    invoiceNumber: invoiceNumber,
                },
                success: (res) => {
                    const transaction = res.data.transaction;
                    const transactionDetail = res.data.transactionDetail;

                    let PRINTER_POS = JSON.parse(localStorage.getItem('print_kasir'));

                    connectQZ().then(() => {
                        let config = qz.configs.create(PRINTER_POS);

                        // ================== KONSTANTA ESC/POS ==================
                        const ESC = "\x1B";
                        const GS  = "\x1D";

                        const INIT         = ESC + "@";
                        const ALIGN_LEFT   = ESC + "a" + "\x00";
                        const ALIGN_CENTER = ESC + "a" + "\x01";
                        const ALIGN_RIGHT  = ESC + "a" + "\x02";
                        const BOLD_ON      = ESC + "E" + "\x01";
                        const BOLD_OFF     = ESC + "E" + "\x00";

                        const LINE_WIDTH = 32;

                        // ================== HELPER FUNCTION ==================

                        function separator() {
                            return "-".repeat(LINE_WIDTH) + "\n";
                        }

                        function padLeft(text, width) {
                            if (text.length > width) return text.substring(0, width);
                            return " ".repeat(width - text.length) + text;
                        }

                        function padRight(text, width) {
                            if (text.length > width) return text.substring(0, width);
                            return text + " ".repeat(width - text.length);
                        }

                        function formatMoney(n) {
                            return `Rp ${n.toLocaleString("id-ID")}`;
                        }

                        function wrapText(text, width) {
                            if (!text) return [];
                            const words = String(text).split(/\s+/);
                            const lines = [];
                            let line = "";
                            for (const w of words) {
                                if ((line ? line.length + 1 + w.length : w.length) <= width) {
                                    line = line ? (line + " " + w) : w;
                                } else {
                                    if (line) lines.push(line);
                                    if (w.length > width) {
                                        let start = 0;
                                        while (start < w.length) {
                                            lines.push(w.slice(start, start + width));
                                            start += width;
                                        }
                                        line = "";
                                    } else {
                                        line = w;
                                    }
                                }
                            }
                            if (line) lines.push(line);
                            return lines;
                        }

                        function itemLine(name, qty = 1, price = 0, addon = [], variant = [], note = null) {
                            const qtyStr = `x${qty}`;
                            const priceStr = formatMoney(price);

                            const main = `${name} ${qtyStr}`;

                            const extraBlocks = [];
                            if (Array.isArray(addon) && addon.length) {
                                extraBlocks.push("Addon:");
                                addon.forEach(a => {
                                    const aPrice = a.addon_price ?? 0;
                                    extraBlocks.push(`  ${a.addon_name} ${aPrice.toLocaleString("id-ID")} x${a.qty}`);
                                });
                            }

                            if (Array.isArray(variant) && variant.length) {
                                extraBlocks.push("Variant:");
                                variant.forEach(v => {
                                    const vPrice = v.variant_price ?? 0;
                                    extraBlocks.push(`  ${v.variant_name}: ${v.variant_value} ${vPrice.toLocaleString("id-ID")}`);
                                });
                            }

                            if (note) {
                                extraBlocks.push(`Note: ${note}`);
                            }

                            const outputLines = [];

                            const availForFirst = LINE_WIDTH - priceStr.length;
                            const mainWrapped = wrapText(main, Math.max(1, availForFirst));

                            const firstMainLine = mainWrapped.length ? mainWrapped.shift() : "";
                            const pad = Math.max(1, availForFirst - firstMainLine.length);
                            outputLines.push(firstMainLine + " ".repeat(pad) + priceStr);

                            mainWrapped.forEach(l => outputLines.push(l));

                            extraBlocks.forEach(block => {
                                const wrapped = wrapText(block, LINE_WIDTH);
                                wrapped.forEach(l => outputLines.push(l));
                            });

                            return outputLines.map(l => l + "\n").join("");
                        }

                        // ESC/POS QR Code - RETURN STRING
                        function buildQrCommands(qrData) {
                            if (!qrData) return "";

                            const model = GS + "(k" + String.fromCharCode(4, 0, 49, 65, 50, 0);
                            const size  = GS + "(k" + String.fromCharCode(3, 0, 49, 67, 6);
                            const ecc   = GS + "(k" + String.fromCharCode(3, 0, 49, 69, 48);

                            const storeLen = qrData.length + 3;
                            const pL = storeLen & 0xFF;
                            const pH = (storeLen >> 8) & 0xFF;
                            const store = GS + "(k" + String.fromCharCode(pL, pH, 49, 80, 48) + qrData;

                            const print = GS + "(k" + String.fromCharCode(3, 0, 49, 81, 48);

                            return model + size + ecc + store + print;
                        }

                        // BUILD RECEIPT - RETURN STRING (BUKAN ARRAY)
                        function buildReceipt(items, meta) {
                            let output = "";

                            // HEADER
                            output += INIT;
                            output += ALIGN_CENTER;
                            output += BOLD_ON;
                            output += (meta.storeName || "").toUpperCase() + "\n\n";
                            output += BOLD_OFF;
                            output += ALIGN_LEFT;
                            output += `DATE  : ${meta.dateTime}\n`;
                            output += `INV NO: ${meta.rctNo}\n`;
                            output += `CASHIER: ${meta.cashierName}\n`;
                            output += ALIGN_CENTER;
                            output += BOLD_ON;
                            output += "\n*SALES RECEIPT*\n\n";
                            output += BOLD_OFF;
                            output += ALIGN_LEFT;

                            // LIST ITEM
                            items.forEach(it => {
                                output += itemLine(it.name, it.qty, it.price, it.addon, it.variant, it.note);
                            });

                            output += "\n";

                            // PEMBAYARAN
                            output += padRight(meta.paymentName || "PAYMENT", 24) + "\n";
                            output += padRight("# ITEM SOLD", 24) + padLeft(String(items.length), 8) + "\n";
                            output += padRight("SUB TOTAL", 24) + padLeft(formatMoney(meta.subtotal), 8) + "\n";
                            output += padRight("DISC", 24) + padLeft(formatMoney(meta.discount), 8) + "\n";
                            output += padRight("TOTAL", 24) + padLeft(formatMoney(meta.total), 8) + "\n";
                            output += "\n";

                            // QR CODE
                            if (meta.orderNo) {
                                output += ALIGN_CENTER;
                                output += buildQrCommands(meta.orderNo);
                                output += "\n";
                                output += "Scan QR untuk detail pesanan\n\n";
                            }

                            // FOOTER
                            output += "Harga sudah termasuk pajak\n";
                            output += "WA : 0898-3862-898\n";
                            output += "FB, IG & TIKTOK @KedaiSelvin\n";
                            output += "\n";
                            output += "Nomor Antrian Anda\n";
                            output += "\n";

                            // ANGKA BESAR BOLD TENGAH
                            output += "\x1B\x61\x01";     // center
                            output += "\x1B\x45\x01";     // bold on
                            output += "\x1D\x21\x11";     // double width & height
                            output += `${meta.orderNumber}\n`;
                            output += "\x1D\x21\x00";     // reset size
                            output += "\x1B\x45\x00";     // bold off
                            output += "\x1B\x61\x00";     // left align

                            output += "\n\n\n";
                            output += GS + "V" + "\x00";  // cutter

                            return output;  // RETURN STRING
                        }

                        // ================== SIAPKAN DATA ==================
                        let items = [];
                        transactionDetail.forEach((detail) => {
                            items.push({
                                name: detail.menu.name,
                                qty: detail.qty,
                                price: detail.total,
                                note: detail.note,
                                addon: detail.addon ?? [],
                                variant: detail.variant ?? [],
                            });
                        });

                        function formatDateTime(dateString) {
                            const d = new Date(dateString);

                            const day    = String(d.getDate()).padStart(2, '0');
                            const month  = String(d.getMonth() + 1).padStart(2, '0');
                            const year   = d.getFullYear();
                            const hour   = String(d.getHours()).padStart(2, '0');
                            const minute = String(d.getMinutes()).padStart(2, '0');

                            return `${day}/${month}/${year} ${hour}:${minute}`;
                        }

                        const meta = {
                            storeName:   transaction.outlet.name,
                            rctNo:       transaction.invoice_number,
                            cashierName: transaction.users.name,
                            dateTime:    formatDateTime(transaction.created_at),
                            paymentName: transaction.payment_method.name,
                            orderNo:     transaction.invoice_number,
                            orderNumber: transaction.order_number,
                            subtotal:    transaction.subtotal,
                            discount:    transaction.discount,
                            total:       transaction.total
                        };

                        // BUILD DATA ESC/POS (SEKARANG RETURN STRING)
                        let data = buildReceipt(items, meta);

                        // ================== PRINT ==================
                        let printFlow = Promise.resolve();

                        // Cash Drawer (jika payment Cash)
                        if (transaction.payment_method.name === 'Cash') {
                            printFlow = printFlow
                                .then(() => qz.print(config, ["\x1B\x70\x00\x19\xFA"]))
                                .then(() => new Promise(resolve => setTimeout(resolve, 400)));
                        }

                        // Print Receipt
                        printFlow
                            .then(() => qz.print(config, [data]))  // KIRIM SEBAGAI ARRAY 1 STRING
                            .then(() => {
                                console.log("Struk selesai diprint");
                            })
                            .catch(err => {
                                console.error(err);
                                alert("Gagal print: " + err);
                            });

                    });

                }
            });
        }

        const PRINTER_KITCHEN = "PRINT_DAPUR";
        function printNotaKitchen(invoiceNumber) {
            $.ajax({
                url: '{{ route('pos.find.transaction') }}',
                method: 'GET',
                data: {
                    invoiceNumber: invoiceNumber,
                },
                success: (res) => {
                    const transaction = res.data.transaction;
                    const transactionDetail = res.data.transactionDetail;

                    let PRINTER_KITCHEN = JSON.parse(localStorage.getItem('print_dapur'));

                    connectQZ().then(() => {
                        let config = qz.configs.create(PRINTER_KITCHEN, {
                            forceRaw: true
                        });

                        // ================== KONSTANTA ESC/POS ==================
                        const ESC = "\x1B";
                        const GS  = "\x1D";

                        const INIT         = ESC + "@";
                        const ALIGN_LEFT   = ESC + "a" + "\x00";
                        const ALIGN_CENTER = ESC + "a" + "\x01";
                        const ALIGN_RIGHT  = ESC + "a" + "\x02";
                        const BOLD_ON      = ESC + "E" + "\x01";
                        const BOLD_OFF     = ESC + "E" + "\x00";

                        const LINE_WIDTH = 32; // kira-kira lebar karakter kertas 58mm

                        // ================== HELPER FUNCTION ==================

                        function separator() {
                            return "-".repeat(LINE_WIDTH) + "\n";
                        }

                        function padLeft(text, width) {
                            if (text.length > width) return text.substring(0, width);
                            return " ".repeat(width - text.length) + text;
                        }

                        function padRight(text, width) {
                            if (text.length > width) return text.substring(0, width);
                            return text + " ".repeat(width - text.length);
                        }

                        function formatMoney(n) {
                            return `Rp ${n.toLocaleString("id-ID")}`;
                        }

                        function wrapText(text, width) {
                            if (!text) return [];
                            const words = String(text).split(/\s+/);
                            const lines = [];
                            let line = "";
                            for (const w of words) {
                                if ((line ? line.length + 1 + w.length : w.length) <= width) {
                                    line = line ? (line + " " + w) : w;
                                } else {
                                    if (line) lines.push(line);
                                    if (w.length > width) {
                                        // hard-split very long word
                                        let start = 0;
                                        while (start < w.length) {
                                            lines.push(w.slice(start, start + width));
                                            start += width;
                                        }
                                        line = "";
                                    } else {
                                        line = w;
                                    }
                                }
                            }
                            if (line) lines.push(line);
                            return lines;
                        }

                        function itemLine(name, qty = 1, price = 0, addon = [], variant = [], note = null) {
                            const qtyStr = `x${qty}`;
                            const totalPrice = qty * price;
                            const priceStr = formatMoney(totalPrice);

                            // Baris utama (nama + qty) — ini yang akan dipasangkan dengan price di baris pertama
                            const main = `${name} ${qtyStr}`;

                            // Kumpulkan blok tambahan (tanpa menambahkan newline ke main)
                            const extraBlocks = [];
                            if (Array.isArray(addon) && addon.length) {
                                extraBlocks.push("Addon:");
                                addon.forEach(a => {
                                    const aPrice = a.addon_price ?? 0;
                                    extraBlocks.push(`${a.addon_name} ${aPrice.toLocaleString("id-ID")} x${a.qty}`);
                                });
                            }

                            if (Array.isArray(variant) && variant.length) {
                                extraBlocks.push("Variant:");
                                variant.forEach(v => {
                                    const vPrice = v.variant_price ?? 0;
                                    extraBlocks.push(`${v.variant_name}: ${v.variant_value} ${vPrice.toLocaleString("id-ID")}`);
                                });
                            }

                            if (note !== null && note !== undefined && String(note).trim() !== "") {
                                extraBlocks.push(`Note: ${note}`);
                            }

                            const outputLines = [];

                            // Baris pertama: main (wrapped jika perlu) + price di kanan
                            const availForFirst = LINE_WIDTH - priceStr.length;
                            const mainWrapped = wrapText(main, Math.max(1, availForFirst));

                            // gunakan baris pertama dari mainWrapped sebagai baris dengan price
                            const firstMainLine = mainWrapped.length ? mainWrapped.shift() : "";
                            const pad = Math.max(1, availForFirst - firstMainLine.length);
                            outputLines.push(firstMainLine + " ".repeat(pad) + priceStr);

                            // sisa dari mainWrapped menjadi baris biasa
                            mainWrapped.forEach(l => outputLines.push(l));

                            // lalu tambahkan extraBlocks (wrap per baris)
                            extraBlocks.forEach(block => {
                                const wrapped = wrapText(block, LINE_WIDTH);
                                wrapped.forEach(l => outputLines.push(l));
                            });

                            // akhiri setiap baris dengan newline
                            return outputLines.map(l => l + "\n").join("");
                        }

                        // ESC/POS QR Code
                        function buildQrCommands(qrData) {
                            // Model 2
                            const model = GS + "(k" + String.fromCharCode(4, 0, 49, 65, 50, 0);
                            // Size (1-16)
                            const size  = GS + "(k" + String.fromCharCode(3, 0, 49, 67, 6);
                            // Error correction level L
                            const ecc   = GS + "(k" + String.fromCharCode(3, 0, 49, 69, 48);

                            // Store data
                            const storeLen = qrData.length + 3;
                            const pL = storeLen & 0xFF;
                            const pH = (storeLen >> 8) & 0xFF;
                            const store = GS + "(k" + String.fromCharCode(pL, pH, 49, 80, 48) + qrData;

                            // Print QR
                            const print = GS + "(k" + String.fromCharCode(3, 0, 49, 81, 48);

                            return [model, size, ecc, store, print];
                        }

                        function buildReceipt(items, meta) {
                            const total = items.reduce((sum, i) => sum + i.qty * i.price, 0);
                            const totalStr = `Rp ${total.toLocaleString("id-ID")}`;

                            let data = [
                                INIT,

                                // HEADER
                                ALIGN_CENTER,
                                BOLD_ON,
                                (meta.storeName || "").toUpperCase() + "\n\n",
                                BOLD_OFF,

                                ALIGN_LEFT,
                                `DATE  : ${meta.dateTime}\n`,
                                `INV NO: ${meta.rctNo}\n`,
                                `CASHIER: ${meta.cashierName}\n`,

                                ALIGN_CENTER,
                                BOLD_ON,
                                "\n*SALES RECEIPT*",
                                "\n\n",
                                BOLD_OFF,
                                ALIGN_LEFT
                            ];

                            // LIST ITEM
                            items.forEach(it => {
                                data.push(itemLine(it.name, it.qty, it.price, it.addon, it.variant, it.note));
                            });

                            data.push("\n");
                            data.push(
                                padRight("# ITEM SOLD", 24) + padLeft(String(items.length), 8) + "\n",
                            );

                            data.push("\n");

                            // FOOTER
                            data.push(
                                "Nomor Antrian Anda\n",
                                "\n",

                                // ================== ANGKA 58 BESAR BOLD TENGAH ==================
                                "\x1B\x61\x01",     // center
                                "\x1B\x45\x01",     // bold on
                                "\x1D\x21\x11",     // text double width & double height (besar)
                                `${transaction.order_number}`+'\n',
                                "\x1D\x21\x00",     // reset size normal
                                "\x1B\x45\x00",     // bold off
                                "\x1B\x61\x00",     // left alignment kembali normal
                                // ===============================================================

                                "\n\n\n",
                                GS + "V" + "\x00"    // cutter
                            );

                            return data;
                        }

                        // ================== DUMMY DATA TEST ==================
                        // const items = [
                        //     { name: "ICE KSK LARGE", qty: 1, price: 19000 },
                        //     { name: "ROTI COKLAT",   qty: 2, price: 8000  }
                        // ];

                        let items = [];
                        transactionDetail.forEach((detail) => {
                            items.push({
                                name: detail.menu.name,
                                qty: detail.qty,
                                price: detail.total,
                                note: detail.note,
                                addon: detail.addon ?? [],
                                variant: detail.variant ?? [],
                            });
                        });

                        function formatDateTime(dateString) {
                            const d = new Date(dateString);

                            const day    = String(d.getDate()).padStart(2, '0');
                            const month  = String(d.getMonth() + 1).padStart(2, '0');
                            const year   = d.getFullYear();
                            const hour   = String(d.getHours()).padStart(2, '0');
                            const minute = String(d.getMinutes()).padStart(2, '0');

                            return `${day}/${month}/${year} ${hour}:${minute}`;
                        }

                        const meta = {
                            storeName:   transaction.outlet.name,
                            rctNo:       transaction.invoice_number,
                            cashierName: transaction.users.name,
                            dateTime:    formatDateTime(transaction.created_at),
                            paymentName: transaction.payment_method.name,
                            orderNo:     transaction.invoice_number
                        };

                        // build data ESC/POS untuk dikirim ke printer
                        let data = buildReceipt(items, meta);

                        // Cash Drawer
                        let printFlow = Promise.resolve();

                        if (transaction.payment_method.name === 'Cash') {
                            printFlow = printFlow
                                .then(() => qz.print(config, ["\x1B\x70\x00\x19\xFA"]))
                                .then(() => new Promise(resolve => setTimeout(resolve, 400)));
                        }

                        printFlow
                            .then(() => qz.print(config, data))
                            .then(() => {
                                console.log("Struk selesai diprint");
                            })
                            .catch(err => {
                                console.error(err);
                                alert("Gagal print: " + err);
                            });

                    });

                }
            });
        }
    </script>
@endsection