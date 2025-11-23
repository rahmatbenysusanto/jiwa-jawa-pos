<script>
    qz.security.setCertificatePromise(function (resolve, reject) {
        resolve("-----BEGIN CERTIFICATE-----\nMIID...demo...CERT...\n-----END CERTIFICATE-----\n");
    });

    qz.security.setSignaturePromise(function (toSign) {
        return function(resolve, reject) {
            resolve(null);
        };
    });

    function connectQZ() {
        if (!qz.websocket.isActive()) {
            return qz.websocket.connect().catch(function(err) {
                console.error("QZ connect error:", err);
                alert("QZ Tray belum jalan di komputer kasir.");
            });
        }
        return Promise.resolve();
    }

    const PRINTER_TEST = "POS-58";

    function printInvoicePOS(orderNumber) {
        $.ajax({
            url: '',
            method: 'GET',
            data: {
                orderNumber: orderNumber,
            },
            success: (res) => {
                const transaction = res.data.transaction;

                connectQZ().then(() => {
                    let config = qz.configs.create(PRINTER_TEST, {
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

                    // 1 baris item: "ICE KSK LARGE x1      Rp 19.000"
                    function itemLine(name, qty, price) {
                        const qtyStr   = `x${qty}`;
                        const priceStr = `Rp ${ (qty * price).toLocaleString("id-ID") }`;

                        let left = `${name} ${qtyStr}`;
                        if (left.length > 20) left = left.substring(0, 20);

                        const spaces = LINE_WIDTH - left.length - priceStr.length;
                        return left + " ".repeat(spaces > 0 ? spaces : 1) + priceStr + "\n";
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
                            (meta.storeName || "").toUpperCase() + "\n",
                            BOLD_OFF,

                            ALIGN_LEFT,
                            `DATE  : ${meta.dateTime}\n`,
                            `INV NO: ${meta.rctNo}\n`,
                            `CASHIER: ${meta.cashierName}\n`,
                            separator(),

                            ALIGN_CENTER,
                            BOLD_ON,
                            "*SALES RECEIPT*\n",
                            BOLD_OFF,
                            ALIGN_LEFT
                        ];

                        // LIST ITEM
                        items.forEach(it => {
                            data.push(itemLine(it.name, it.qty, it.price));
                        });

                        data.push("\n");
                        data.push(
                            padRight("TOTAL", 24) + padLeft(totalStr, 8) + "\n",
                            separator()
                        );

                        // PEMBAYARAN
                        const payStr = `Rp ${total.toLocaleString("id-ID")}`;
                        data.push(
                            padRight(meta.paymentName || "PAYMENT", 24) + padLeft(payStr, 8) + "\n"
                        );

                        if (meta.paymentRef) {
                            data.push(meta.paymentRef + "\n");
                        }

                        data.push("\n");

                        data.push(
                            padRight("TOTAL PAID", 24) + padLeft(totalStr, 8) + "\n",
                            padRight("CHANGES", 24)   + padLeft("Rp 0", 8) + "\n",
                            padRight("# ITEM SOLD", 24) + padLeft(String(items.length), 8) + "\n",
                            "\n",
                            `DPP Nilai Lain : 0\n`,
                            `DPP : ${meta.dpp.toLocaleString("id-ID")}\n`,
                            `PPN : ${meta.ppn.toLocaleString("id-ID")}\n`,
                            `PB1 : ${meta.pb1.toLocaleString("id-ID")}\n`,
                            "\n"
                        );

                        // QR CODE + NOMOR ORDER
                        const qrPayload = meta.orderNo; // bisa diganti URL / payload lain
                        data.push(ALIGN_CENTER);
                        buildQrCommands(qrPayload).forEach(cmd => data.push(cmd));
                        data.push("\n");
                        data.push(meta.orderNo + "\n");
                        data.push("\n");

                        // FOOTER
                        data.push(
                            "Harga sudah termasuk pajak\n",
                            "PT Fajar Mitra Indah\n",
                            "WA Business : 0898-3862-898\n",
                            "FB, IG & TIKTOK @FamilyMartID\n",
                            "TWITTER @FamilyMart_ID\n",
                            "\n",
                            "Nomor Antrian Anda\n",
                            "\n\n\n",
                            GS + "V" + "\x00",
                            "58",
                            "\n\n\n",
                            "\n\n\n",
                        );

                        return data;
                    }

                    // ================== DUMMY DATA TEST ==================
                    const items = [
                        { name: "ICE KSK LARGE", qty: 1, price: 19000 },
                        { name: "ROTI COKLAT",   qty: 2, price: 8000  }
                    ];

                    const meta = {
                        storeName:   "Kedai Selvin",
                        posId:       "002",
                        rctNo:       "91250802300290873",
                        cashierName: "Nurul Aisyah",
                        dateTime:    "23/08/2025 13:01",
                        paymentName: "BCA QRIS",
                        paymentRef:  "023600220250823130005004010",
                        dpp:         17273,
                        ppn:         0,
                        pb1:         1727,
                        orderNo:     "ORD-250823-0001"
                    };

                    // build data ESC/POS untuk dikirim ke printer
                    let data = buildReceipt(items, meta);

                    // ================== KIRIM KE PRINTER ==================
                    qz.print(config, data)
                        .then(() => {
                            alert("Berhasil kirim ke printer!");
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