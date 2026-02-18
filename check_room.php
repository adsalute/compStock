<?php include "middleware/db.php"; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/html5-qrcode"></script>
</head>

<body class="bg-light">

<div class="container mt-3">

<h4>ตรวจครุภัณฑ์ตามห้อง</h4>

<select id="room" class="form-select mb-3" onchange="loadExpected()">
<option value="">-- เลือกห้อง --</option>

<?php
$res = $conn->query("SELECT * FROM rooms");
while($r = $res->fetch_assoc()){
echo "<option value='$r[room_code]'>$r[room_name]</option>";
}
?>
</select>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#scanModal">
📷 เริ่มสแกน
</button>

<h5>รายการในห้อง</h5>
<table class="table table-bordered">
<thead>
<tr>
<th>Serial</th>
<th>ชื่อ</th>
<th>สถานะ</th>
</tr>
</thead>
<tbody id="expectedTable"></tbody>
</table>

<h5>ของเกิน</h5>
<table class="table table-bordered">
<tbody id="extraTable"></tbody>
</table>

</div>

<audio id="beep" src="beep.mp3"></audio>

<!-- MODAL SCAN -->
<div class="modal fade" id="scanModal">
<div class="modal-dialog modal-fullscreen-sm-down">
<div class="modal-content">

<div class="modal-header">
<h5>Scanner</h5>
<button class="btn-close" data-bs-dismiss="modal" onclick="stopScanner()"></button>
</div>

<div class="modal-body text-center">

<div id="reader"></div>
<button class="btn btn-warning mt-2" onclick="toggleFlash()">🔦 Flash</button>

</div>
</div>
</div>
</div>

<script>

let html5QrCode;
let expectedItems = new Map();
let scannedItems = new Set();
let flashOn = false;

function loadExpected(){

fetch("get_room_asset.php?room="+room.value)
.then(res=>res.json())
.then(data=>{

expectedItems.clear();
scannedItems.clear();
expectedTable.innerHTML="";
extraTable.innerHTML="";

data.forEach(item=>{

expectedItems.set(item.serial_no,item.asset_name);

expectedTable.innerHTML += `
<tr id="row-${item.serial_no}">
<td>${item.serial_no}</td>
<td>${item.asset_name}</td>
<td class="text-danger">ยังไม่พบ</td>
</tr>`;
});
});
}

document.getElementById('scanModal')
.addEventListener('shown.bs.modal', startScanner);

function startScanner(){

html5QrCode = new Html5Qrcode("reader");

html5QrCode.start(
{ facingMode:"environment" },
{ fps:15, qrbox:250 },
onScanSuccess
);
}

function onScanSuccess(code){

if(scannedItems.has(code)) return;

scannedItems.add(code);

document.getElementById("beep").play();
if(navigator.vibrate) navigator.vibrate(200);

if(expectedItems.has(code)){

document.querySelector(`#row-${code} td:nth-child(3)`)
.innerHTML="<span class='text-success'>พบแล้ว</span>";

}else{

extraTable.innerHTML += `
<tr class="table-warning">
<td>${code}</td>
<td>ไม่อยู่ในห้องนี้</td>
<td>🟡</td>
</tr>`;
}
}

function stopScanner(){
if(html5QrCode){
html5QrCode.stop().then(()=>html5QrCode.clear());
}
}

function toggleFlash(){

html5QrCode.getRunningTrackCapabilities().then(cap=>{

if(cap.torch){

flashOn = !flashOn;

html5QrCode.applyVideoConstraints({
advanced: [{ torch: flashOn }]
});

}else{
alert("อุปกรณ์ไม่รองรับไฟฉาย");
}

});
}

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
