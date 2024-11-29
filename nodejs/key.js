const crypto = require('crypto');
const fs = require('fs');

// Tạo cặp khóa ECDSA với curve 'prime256v1'
function generateKeys() {
  const { publicKey, privateKey } = crypto.generateKeyPairSync('ec', {
    namedCurve: 'prime256v1',
    publicKeyEncoding: { type: 'spki', format: 'pem' },
    privateKeyEncoding: { type: 'pkcs8', format: 'pem' },
  });

  // Lưu khóa vào file
  fs.writeFileSync('private_key.pem', privateKey);
  fs.writeFileSync('public_key.pem', publicKey);

  console.log('Cặp khóa đã được tạo và lưu.');
}

// Tạo cặp khóa khi chạy file này
generateKeys();
