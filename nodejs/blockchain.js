const crypto = require('crypto');
const fs = require('fs');
const {isString} = require('lodash');
const path = require('path');
const axios = require("axios");
const usb = require('usb');

// Định nghĩa Block
class Block {
    constructor(index, timestamp, data, previousHash = '', signature = '', hash = '') {
        this.index = index;
        this.timestamp = timestamp;
        this.data = data;
        this.previousHash = previousHash;
        this.signature = signature;
        this.hash = hash; // Khóa hash ban đầu
    }

    // Tính hash cho block
    // Tính hash cho block (bỏ qua chữ ký)
    calculateHash() {
        const dataToHash =
            this.index +
            this.timestamp +
            JSON.stringify(this.data) +
            this.previousHash;  // Không bao gồm chữ ký

        console.log(`Dữ liệu để hash (Block ${this.index}): ${dataToHash}`); // Log để kiểm tra

        return crypto.createHash('sha256').update(dataToHash).digest('hex');
    }


    // Khóa hash để tránh chỉnh sửa sau khi tính toán
    lockHash() {
        this.hash = this.calculateHash();
        console.log(`Hash đã khóa cho Block ${this.index}: ${this.hash}`); // Log hash để kiểm tra
    }

    // Ký block bằng private key sau khi hash đã được khóa
    signBlock(privateKey) {
        const sign = crypto.createSign('SHA256');
        sign.update(this.hash).end();
        this.signature = sign.sign(privateKey, 'hex');
        console.log(`Chữ ký cho Block ${this.index}: ${this.signature}`); // Log chữ ký để kiểm tra
    }

    // Xác minh chữ ký của block
    verifySignature(publicKey) {
        const verify = crypto.createVerify('SHA256');
        verify.update(this.hash).end();
        return verify.verify(publicKey, this.signature, 'hex');
    }
}

// Định nghĩa Blockchain
class Blockchain {
    constructor() {
        this.getLastBlock().then(async (data) => {
            if (data) {
                this.chain = [this.genBlock(data)]
            } else {
                this.chain = [this.createGenesisBlock()]
            }
        })
    }

    genBlock(currentBlock) {
        currentBlock['data'] = JSON.parse(currentBlock['data'])
        return new Block(currentBlock.index, currentBlock.timestamp, currentBlock.data, currentBlock.previousHash, currentBlock.signature, currentBlock.hash);
    }

    async getLastBlock() {
        try {
            const url = 'http://localhost:8000/api/admin/blocks/get-last';
            // Optional: If you need to send any data (e.g., for POST requests)
            // Example of a GET request
            const response = await axios.get(url);
            return response.data;
        } catch (error) {
            return error.response ? error.response.data : error.message;
            // console.error('Error calling Laravel API:', error.response ? error.response.data : error.message);
        }
    }

    // Tạo block đầu tiên (Genesis Block)
    createGenesisBlock() {
        const genesisBlock = new Block(0, new Date().toISOString(), {message: 'Genesis Block'}, '0');
        genesisBlock.lockHash();
        return genesisBlock;
    }

    // Lấy block cuối cùng
    getLatestBlock() {
        return this.chain[this.chain.length - 1];
    }

    // Thêm block mới
    addBlock(newBlock, privateKey) {
        newBlock.previousHash = this.getLatestBlock().hash;
        newBlock.lockHash();
        newBlock.signBlock(privateKey);

        this.chain.push(newBlock);
        this.saveBlockToFile(newBlock);
    }

    // Lưu block vào file JSON
    saveBlockToFile(block) {
        // const filePath = path.join(__dirname, 'blocks', `block_${block.index}.json`);
        // fs.writeFileSync(filePath, JSON.stringify(block, null, 2));
        // console.log(`Block ${block.index} đã được lưu tại ${filePath}`);
    }

    // Xác thực toàn bộ chuỗi blockchain
    isChainValid(publicKey, data, providedSignature) {
        var valid = false
        var validSign = false
        for (let i = 1; i < data.length; i++) {
            var currentBlock = data[i];
            currentBlock['data'] = JSON.parse(currentBlock['data'])
            currentBlock = new Block(currentBlock.index, currentBlock.timestamp, currentBlock.data, currentBlock.previousHash, currentBlock.signature, currentBlock.hash);

            var previousBlock = data[i - 1];
            if (previousBlock['data'] && isString(previousBlock['data'])) {
                previousBlock['data'] = JSON.parse(previousBlock['data'])
            }

            previousBlock = new Block(previousBlock.index, previousBlock.timestamp, previousBlock.data, previousBlock.previousHash, previousBlock.signature, previousBlock.hash);

            console.log(`Kiểm tra Block ${currentBlock.index}...`);
            console.log(`Hash hiện tại: ${currentBlock.hash}`);
            console.log(`Hash tính lại: ${currentBlock.calculateHash()}`);


            // Kiểm tra hash
            if (currentBlock.hash !== currentBlock.calculateHash()) {
                console.log(`Block ${currentBlock.index}: Hash không khớp.`);
                valid = false;
            } else {
                valid = true
            }

            // Kiểm tra previousHash
            if (currentBlock.previousHash !== previousBlock.hash) {
                console.log(`Block ${currentBlock.index}: Previous hash không khớp.`);
                valid = false;
            } else {
                valid = true
            }
            const isSignatureValid = currentBlock.verifySignature(publicKey);
            if (!isSignatureValid) {
                console.log(`Block ${currentBlock.index}: Chữ ký không hợp lệ.`);
                valid = false;
            } else {
                valid = true
            }

            if (currentBlock.signature === providedSignature) {
                console.log(`Block ${currentBlock.index}: Chữ ký khớp với chữ ký đã cung cấp.`);
                validSign = true
            }
        }
        return valid && validSign;
    }
}


function generateKeys(saveFile = false) {
    const {publicKey, privateKey} = crypto.generateKeyPairSync('ec', {
        namedCurve: 'prime256v1',
        publicKeyEncoding: {type: 'spki', format: 'pem'},
        privateKeyEncoding: {type: 'pkcs8', format: 'pem'},
    });
    if (saveFile) {
        //Vendor ID: 1423
        //Product ID: 25479
        const YOUR_USB_VENDOR_ID = 1423
        const YOUR_USB_PRODUCT_ID = 25479
        const devices = usb.getDeviceList();
        devices.forEach(device => {
            // So sánh với vendorId và productId bạn cần tìm
            if (device.deviceDescriptor.idVendor === YOUR_USB_VENDOR_ID && device.deviceDescriptor.idProduct === YOUR_USB_PRODUCT_ID) {

              // Lấy mô tả về thiết bị và các thuộc tính khác
            //   device.open();
              console.log("Device path:", device);

              // Bạn có thể thực hiện các thao tác đọc/ghi với thiết bị tại đây
            }
        });



        // const usbPath ='E:/'
        // Lưu khóa vào file
        // fs.writeFileSync('private_key.pem', privateKey);
        // fs.writeFileSync('public_key.pem', publicKey);
        // console.log('Cặp khóa đã được tạo và lưu.');
        // Ghi public key vào USB
        // fs.writeFileSync(`${usbPath}/private_key.pem`, publicKey);
        // console.log('Public key đã được lưu vào USB.');

        // Ghi private key vào USB
        // fs.writeFileSync(`${usbPath}/public_key.pem`,privateKey);
        // console.log('Private key đã được lưu vào USB.');
    }
    return {publicKey, privateKey}

}

module.exports = {Blockchain, Block, generateKeys};
