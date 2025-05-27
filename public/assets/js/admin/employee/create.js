function generateUUID() {
    var d = new Date().getTime(); // Waktu sekarang
    var d2 = (performance && performance.now && (performance.now() * 1000)) || 0; // Waktu presisi tinggi jika tersedia
  
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16; // Angka random dari 0 sampai 15
    
        if (d > 0) {
            r = (d + r) % 16 | 0;
            d = Math.floor(d / 16);
        } else {
            r = (d2 + r) % 16 | 0;
            d2 = Math.floor(d2 / 16);
        }
  
      return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}

document.getElementById('id').value = generateUUID();

document.getElementById('submit_button').removeAttribute('disabled');