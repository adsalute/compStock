<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/html5-qrcode"></script>

<style>

#reader{
  position:relative;
  border-radius:15px;
  overflow:hidden;
}

/* เส้นสแกน */
.scan-line{
  position:absolute;
  left:10%;
  width:80%;
  height:3px;
  background:red;
  box-shadow:0 0 8px red;
  animation: scan 2s linear infinite;
  z-index:10;
  transition:.3s;
}

.scan-success{
  background:#00ff00 !important;
  box-shadow:0 0 12px #00ff00 !important;
  animation:none;
}

@keyframes scan{
  0%{ top:20%; }
  50%{ top:80%; }
  100%{ top:20%; }
}

</style>
</head>

<body class="bg-dark text-center text-white">

<div class="container py-5">
  <button class="btn btn-primary" onclick="startScanner()">
    📷 เปิดสแกน
  </button>
</div>

<!-- MODAL -->
<div class="modal fade" id="scanModal">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content bg-black">

      <div class="modal-header border-0">
        <h5>สแกนสินค้า</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div id="reader">
          <div class="scan-line" id="scanLine"></div>
        </div>

        <div id="result" class="mt-3 fs-4"></div>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

let html5QrCode;
let lastScan = "";
let debounce = false;

function startScanner(){

  new bootstrap.Modal(document.getElementById('scanModal')).show();

  html5QrCode = new Html5Qrcode("reader");

  html5QrCode.start(
    { facingMode: "environment" },
    {
      fps:10,
      qrbox:{ width:250, height:120 }
    },
    onScanSuccess
  );
}

function onScanSuccess(code){

  if(debounce || code === lastScan) return;

  debounce = true;
  lastScan = code;

  // เปลี่ยนเส้นเป็นสีเขียว
  const line = document.getElementById("scanLine");
  line.classList.add("scan-success");

  navigator.vibrate(200);
  new Audio("assets/sound/beep.mp3").play();

  document.getElementById("result").innerHTML="⏳ กำลังค้นหา...";

  fetch("check_item.php",{
    method:"POST",
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:"code="+code
  })
  .then(res=>res.json())
  .then(data=>{

    if(data.status==="ok"){
      document.getElementById("result").innerHTML=
      "✅ "+data.name;
    }else{
      document.getElementById("result").innerHTML=
      "❌ ไม่พบข้อมูล";
    }

  });

  setTimeout(()=>{
    line.classList.remove("scan-success");
    debounce=false;
  },1500);
}

</script>

</body>
</html>
