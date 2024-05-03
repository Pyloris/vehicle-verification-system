const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const overlay = document.querySelector('.overlay');
const captureBtn = document.getElementById('capture-btn');
let stream;

async function startCamera() {
    try {
        const devices = await navigator.mediaDevices.enumerateDevices();
        const rearCamera = devices.find(device => device.kind === 'videoinput' && device.label.toLowerCase().includes('rear'));
        const frontCamera = devices.find(device => device.kind === 'videoinput' && device.label.toLowerCase().includes('front'));
        const selectedDevice = rearCamera || frontCamera;

        stream = await navigator.mediaDevices.getUserMedia({
            video: {
                deviceId: selectedDevice ? { exact: selectedDevice.deviceId } : undefined
            }
        });

        video.srcObject = stream;
        video.play();
    } catch (error) {
        console.error('Error accessing camera:', error);
    }
}

startCamera();

function capturePhoto() {
    const context = canvas.getContext('2d');
    const overlayRect = overlay.getBoundingClientRect();
    
    canvas.width = overlayRect.width;
    canvas.height = overlayRect.height;
    
    context.drawImage(video, overlayRect.left, overlayRect.top, overlayRect.width, overlayRect.height, 0, 0, canvas.width, canvas.height);
    
    const imageData = canvas.toDataURL('image/png');

    let org = document.getElementById("org").value;
    console.log(org);
    console.log('Captured image:', imageData);
    
    const formData = new FormData();
    formData.append('org', org);
    formData.append('image', imageData);
    fetch('/ocr', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.status == 200) {
            alert("ALLOWED");
        }
        else {
            alert("NOT ALLOWED");
        }
    })
    .catch(err => console.log(err));
}
