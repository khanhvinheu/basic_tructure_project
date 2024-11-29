const { Blockchain, Block } = require('./blockchain');
const fs = require('fs');

// Đọc khóa từ file
const privateKey = fs.readFileSync('private_key.pem', 'utf8');
const publicKey = fs.readFileSync('public_key.pem', 'utf8');




// Khởi tạo blockchain
const myBlockchain = new Blockchain();

// Thêm các block mới
console.log('Thêm block 1...');
myBlockchain.addBlock(new Block(1, new Date().toISOString(), { amount: 10 }), privateKey);

console.log('Thêm block 2...');
myBlockchain.addBlock(new Block(2, new Date().toISOString(), { amount: 20 }), privateKey);

// Kiểm tra tính hợp lệ của blockchain
const isValid = myBlockchain.isChainValid(publicKey);
console.log('Blockchain hợp lệ?', isValid ? 'Có' : 'Không');
