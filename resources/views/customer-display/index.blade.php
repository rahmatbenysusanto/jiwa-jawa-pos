<!DOCTYPE html>
<html lang="id" data-layout-mode="light_mode">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - Kedai Selvin</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        :root{ --brand:#7F56D8; --brand-50:#efe9fb; --ink:#0f172a; --muted:#64748b; --bg:#f8fafc; }
        body{background:var(--bg); color:var(--ink)}
        .shadow-soft{ box-shadow:0 10px 30px rgba(2,6,23,.08); }
        .rounded-2xl{ border-radius:1rem; }
        .badge-brand{ background:var(--brand-50)!important; color:var(--brand)!important; border:1px solid #e1d6fb; }
        .card-header{ background:#fff; }
        .price-lg{ font-size:1.6rem; font-weight:800; }
        .min-h-100{ min-height:100vh; }

        /* RIGHT PANEL */
        .display-surface{ position:relative; height:100%; min-height:520px; overflow:hidden; }
        .display-layer{ position:absolute; inset:0; }
        .display-layer.hidden{ display:none; }

        /* Promo slider — images only */
        .swiper{ width:100%; height:100%; border-radius:1rem; }
        .swiper-slide{ display:flex; align-items:center; justify-content:center; background:#000; }
        .slide-img{ width:100%; height:100%; object-fit:cover; }

        /* QRIS */
        .qris-wrap{ display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; }
        .qris-card{ background:#fff; border-radius:1rem; padding:1rem 1.25rem; width:min(480px,92%); }
        .qris-amount{ font-weight:800; }
        .hint{ color:var(--muted); font-size:.95rem; }

        /* Empty state keranjang */
        .empty-cart img{ width:130px; opacity:.9 }

        @media (max-width: 991.98px){ .min-h-100{ min-height:auto; } }
    </style>
</head>
<body>
<div class="main-wrapper">
    <div class="container-fluid py-3">
        <div class="row g-3 align-items-stretch min-h-100">
            <!-- LEFT: CART -->
            <div class="col-12 col-lg-6 d-flex">
                <div class="card flex-fill shadow-soft rounded-2xl">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pesanan Anda</h5>
                        <span class="badge badge-brand" id="invoiceNumber"></span>
                    </div>

                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="mb-0">Order Details</h6>
                            <span class="badge badge-brand fw-semibold">Items : <span id="jumlahCart">0</span></span>
                        </div>

                        <div class="product-wrap mb-3" style="min-height:150px;">
                            <div class="empty-cart text-center" id="cartNull">
                                <div class="mb-2">
                                    <img src="{{ asset('assets/img/icons/empty-cart.svg') }}" alt="img">
                                </div>
                                <p class="fw-bold mb-0">No Products Selected</p>
                            </div>

                            <div id="cartValue">
                                <div class="table-responsive">
                                    <table class="table table-borderless align-middle">
                                        <thead>
                                        <tr>
                                            <th class="bg-transparent fw-bold">Product</th>
                                            <th class="bg-transparent fw-bold text-center">QTY</th>
                                            <th class="bg-transparent fw-bold text-end">Price</th>
                                        </tr>
                                        </thead>
                                        <tbody id="listProductCart"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-2">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tr><td class="fw-bold">Sub Total</td><td class="text-end" id="subTotal">Rp 0</td></tr>
                                    <tr><td class="fw-bold">Discount</td><td class="text-danger text-end" id="discount">Rp 0</td></tr>
                                    <tr><td class="fw-bold">Tax (11%)</td><td class="text-end" id="totalTax">Rp 0</td></tr>
                                    <tr class="border-top"><td class="fw-bold">Grand Total</td><td class="text-end price-lg" id="grandTotal">Rp 0</td></tr>
                                </table>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('logout') }}" class="btn btn-sm btn-danger"><i data-feather="log-out" class="me-1"></i> Exit</a>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnFullscreen"><i data-feather="maximize"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: DISPLAY (PROMO / QRIS) -->
            <div class="col-12 col-lg-6 d-flex">
                <div class="card flex-fill shadow-soft rounded-2xl">
                    <div class="card-body p-2">
                        <div class="display-surface rounded-2xl">

                            <!-- LAYER: PROMO SLIDER (images only) -->
                            <div id="layerPromo" class="display-layer">
                                <div class="swiper" id="promoSwiper">
                                    <div class="swiper-wrapper">
                                        <!-- GANTI POSTER PROMO DI SINI (gambar saja) -->
                                        <div class="swiper-slide"><img class="slide-img" src="https://images.unsplash.com/photo-1498804103079-a6351b050096?q=80&w=1600&auto=format&fit=crop" alt="Promo"></div>
                                        <div class="swiper-slide"><img class="slide-img" src="https://images.unsplash.com/photo-1541167760496-1628856ab772?q=80&w=1600&auto=format&fit=crop" alt="Promo"></div>
                                        <div class="swiper-slide"><img class="slide-img" src="https://images.unsplash.com/photo-1551958219-acbc608c6377?q=80&w=1600&auto=format&fit=crop" alt="Promo"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- LAYER: QRIS -->
                            <div id="layerQRIS" class="display-layer hidden">
                                <div class="qris-wrap">
                                    <div class="qris-card shadow-soft">
                                        <div class="text-center mb-2">
                                            <h2 class="fw-bold mb-0" id="storeName">Kedai Selvin</h2>
                                            <small class="text-muted">QRIS Payment</small>
                                            <hr class="mt-2 mb-3">
                                        </div>
                                        <div class="text-center">
                                            <canvas id="qrisCanvas" width="360" height="360" style="margin:auto; display:block;"></canvas>
                                            <p class="mt-3 mb-1">Total Bayar:</p>
                                            <div class="h3 qris-amount" id="qrisAmount">Rp 0</div>
                                            <div class="hint mt-2">Scan dengan aplikasi e-wallet Anda. QR berlaku sesuai waktu dari penyedia.</div>
                                            <img src="{{ asset('assets/img/qris.webp') }}" alt="QRIS" width="90" class="mt-2">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/qrious/dist/qrious.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    // Fullscreen
    (function(){const btn=document.getElementById('btnFullscreen'); const el=document.documentElement; btn?.addEventListener('click',()=>{ if(!document.fullscreenElement) el.requestFullscreen?.(); else document.exitFullscreen?.(); });})();

    // Helpers
    function rupiah(n){ return new Intl.NumberFormat('id-ID').format(n||0); }

    // Swiper (images only)
    const swiper = new Swiper('#promoSwiper', { loop:true, autoplay:{delay:5000, disableOnInteraction:false}, speed:800 });

    // Display state
    function setDisplay(mode){ const promo=document.getElementById('layerPromo'); const qris=document.getElementById('layerQRIS'); if(mode==='qris'){ promo.classList.add('hidden'); qris.classList.remove('hidden'); swiper.autoplay.stop(); } else { qris.classList.add('hidden'); promo.classList.remove('hidden'); swiper.autoplay.start(); } }
    setDisplay('promo');

    // Invoice & cart rendering (tetap sama seperti sebelumnya)
    document.getElementById('invoiceNumber').innerText = localStorage.getItem('invoice') || '';
    document.getElementById('cartValue').style.display = 'none';

    function viewChartList(){
        const cart = JSON.parse(localStorage.getItem('cart')||'[]');
        let html='';
        if(!Array.isArray(cart) || cart.length===0){
            document.getElementById('cartValue').style.display='none';
            document.getElementById('cartNull').style.display='block';
        } else {
            document.getElementById('cartValue').style.display='block';
            document.getElementById('cartNull').style.display='none';
            cart.forEach((item)=>{
                let variantHtml=''; let addonHtml='';
                (item?.data?.variant||[]).forEach(v=>{ (v.option||[]).forEach(o=>{ if(parseInt(o.select)===1){ variantHtml += `${v.name}: ${o.name} - Rp ${rupiah(o.price)}<br>`; } }); });
                (item?.data?.addon||[]).forEach(a=>{ addonHtml += `${a.name}: Rp ${rupiah(a.total)}<br>`; });
                let discountProductHtml=''; (item?.data?.discountProduct||[]).forEach(d=>{ if(parseInt(d.select)===1) discountProductHtml=`<div class="text-danger">Disc: ${d.name}</div>`; });
                let priceHtml='';
                if(parseInt(item.priceDiscount)===0){ priceHtml = `<div class="text-end">Rp ${rupiah(item.grandTotal)}</div>`; }
                else {
                    priceHtml = `<div class=\"text-end text-decoration-line-through\">Rp ${rupiah((parseInt(item.totalPrice)+parseInt(item.priceDelta))*parseInt(item.qty))}</div>`+
                        `${item.priceDiscount?`<div class=\"text-danger text-end\">- Rp ${rupiah(parseInt(item.priceDiscount)*parseInt(item.qty))}</div>`:''}`+
                        `<div class=\"text-end fw-semibold\">Rp ${rupiah(item.grandTotal)}</div>`;
                }
                html += `<tr><td><div class=\"fw-semibold\">${item.name}</div><div class=\"small text-muted\">Base Price : Rp ${rupiah(item.basePrice)}</div>${variantHtml?`<div class=\"small\">${variantHtml}</div>`:''}${item.priceAddon?`<div class=\"small\">Addon:<br>${addonHtml}</div>`:''}${discountProductHtml}</td><td class=\"fw-bold text-center\">${item.qty}</td><td>${priceHtml}</td></tr>`;
            });
            calculatePrice(); calculateJumlahCart();
        }
        document.getElementById('listProductCart').innerHTML = html;
    }

    function calculatePrice(){
        const cart = JSON.parse(localStorage.getItem('cart')||'[]');
        const discountTransaction = JSON.parse(localStorage.getItem('discountTransaction')||'[]');
        let subTotal=0, totalTax=0, discount=0, grandTotal=0;
        cart.forEach((item)=>{ subTotal += parseInt(item.totalPrice)*parseInt(item.qty); discount += parseInt(item.priceDiscount)*parseInt(item.qty); });
        const transDisc = Array.isArray(discountTransaction) ? discountTransaction.find(i=>parseInt(i.select)===1) : undefined;
        if(transDisc){ if(transDisc.type==='nominal') discount += parseInt(transDisc.value); else discount += (subTotal - discount) * (parseInt(transDisc.value)/100); }
        totalTax = (subTotal - discount) * 0.11; grandTotal = subTotal - discount + totalTax;
        localStorage.setItem('subTotal', JSON.stringify(subTotal));
        localStorage.setItem('totalTax', JSON.stringify(totalTax));
        localStorage.setItem('discount', JSON.stringify(discount));
        localStorage.setItem('grandTotal', JSON.stringify(grandTotal));
        document.getElementById('subTotal').innerText='Rp '+rupiah(subTotal);
        document.getElementById('discount').innerText='Rp '+rupiah(discount);
        document.getElementById('totalTax').innerText='Rp '+rupiah(totalTax);
        document.getElementById('grandTotal').innerText='Rp '+rupiah(grandTotal);
    }
    function calculateJumlahCart(){ const cart=JSON.parse(localStorage.getItem('cart')||'[]'); const items=cart.reduce((s,i)=>s+parseInt(i.qty||0),0); document.getElementById('jumlahCart').innerText=items; }

    // QRIS
    function renderQRIS(qrString){ const c=document.getElementById('qrisCanvas'); new QRious({ element:c, value:qrString, size:360 }); }
    function paymentProcess(midtrans){ const qrString=midtrans?.raw?.qr_string??null; const nominal=JSON.parse(localStorage.getItem('grandTotal'))??0; if(qrString){ document.getElementById('qrisAmount').innerText='Rp '+rupiah(nominal); renderQRIS(qrString); setDisplay('qris'); } else { alert('QRIS data is not available.'); } }
    function reset(){ setDisplay('promo'); const c=document.getElementById('qrisCanvas'); const ctx=c.getContext('2d'); ctx.clearRect(0,0,c.width,c.height); window.location.reload(); }

    // Pusher
    Pusher.logToConsole=false; const pusher=new Pusher('e4ffb7304b4636918b68',{cluster:'ap1'}); const channel=pusher.subscribe('selvin-pos');
    channel.bind('transaction-data',function(data){ if(data.username==='{{ Auth::user()->username }}'){ localStorage.setItem('invoice', JSON.stringify(data.invoice)); document.getElementById('invoiceNumber').innerText=data.invoice; switch(data.type){ case 'transaction-data': cartData(data.invoice); break; case 'payment': paymentProcess(data.data); break; case 'reset': reset(); break; } } });

    function cartData(invoiceNumber){ $.ajax({ url:'{{ route('transaction.data.find') }}', method:'GET', data:{ invoiceNumber }, success:(res)=>{ const d=res.data||{}; localStorage.setItem('cart', JSON.stringify(JSON.parse(d.cart||'[]'))); localStorage.setItem('discountTransaction', JSON.stringify(JSON.parse(d.discountTransaction||'[]'))); viewChartList(); } }); }

    // Init
    viewChartList();
</script>
</body>
</html>
