const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const axios = require('axios');
const { Blockchain, Block, generateKeys } = require('./blockchain'); // Adjust the path to your blockchain implementation
const cors = require('cors'); // Thêm cors

const app = express();
const port = 3000;

// Middleware
app.use(bodyParser.json());
// Cấu hình cors để cho phép tất cả các nguồn
app.use(cors());

// Initialize Blockchain
const blockchain = new Blockchain();
function formatPEM(rawKey, type = 'PRIVATE KEY') {
    // Step 1: Clean the key by removing unnecessary characters
    const cleanedKey = rawKey.replace(/(\\n|\n|\r)/g, '').replace(/ /g, '');

    // Step 2: Split the key into 64-character chunks
    const formattedKey = cleanedKey.match(/.{1,64}/g).join('\n');

    // Step 3: Add the BEGIN and END markers
    return `-----BEGIN ${type}-----\n${formattedKey}\n-----END ${type}-----`;
}
async function getIndex(){
    try {
        // Replace with your Laravel API endpoint
        const url = 'http://localhost:8000/api/admin/blocks/get-index';
        // Optional: If you need to send any data (e.g., for POST requests)
        // Example of a GET request
        const response = await axios.get(url);

        return  response.data

      } catch (error) {

        console.error('Error calling Laravel API:', error.response ? error.response.data : error.message);
      }
}

// API endpoint to add a new block
app.post('/add-block', async (req, res) => {
    try {
        // const privateKey = fs.readFileSync('private_key.pem', 'utf8');
        const privateKey = formatPEM(req.body.privateKey)
        const index = await getIndex()
        const newBlock = new Block(index, new Date().toISOString(), { year: 2024 });
        blockchain.addBlock(newBlock, privateKey);
        // // res.status(201).json({ message: 'Block added successfully', block: newBlock ,privateKey:privateKey});

        // Replace with your Laravel API endpoint
        const url = 'http://localhost:8000/api/admin/blocks';
        // Optional: If you need to send any data (e.g., for POST requests)
        const requestData = newBlock;
        // Example of a GET request
        const response = await axios.post(url, requestData);
        // console.log('GET Response:', response.data);
        res.status(201).json({status:true, messages:"Add new block success", newBlock});

    } catch (error) {
        res.status(201).json({status:false, messages:"Add new block error"});
        // console.error('Error calling Laravel API:', error.response ? error.response.data : error.message);
    }
  //api
});

// API endpoint to get all blocks
app.post('/blocks/isChainValid', async(req, res) => {
    try {
        // console.log(req.body.publicKey)
        // Replace with your Laravel API endpoint
        const url = 'http://localhost:8000/api/admin/blocks/get-all';
        // Optional: If you need to send any data (e.g., for POST requests)
        // Example of a GET request
        const response = await axios.get(url);
        // console.log('GET Response:', response.data);
        // const publicKey = fs.readFileSync('public_key.pem', 'utf8');
        const publicKey =  formatPEM(req.body.publicKey, 'PUBLIC KEY')
        const providedSignature = req.body.providedSignature
        const isValid = blockchain.isChainValid(publicKey,response.data,providedSignature);
        if(isValid){
            res.status(200).json({status:true, messages:"Khóa trùng khớp"});
        }else {
            res.status(200).json({status:false, messages:"Khóa không trùng khớp"});
        }

      } catch (error) {
        res.status(200).json({status:false, messages:"Khóa không trùng khớp"});
        // res.status(201).json('Error calling Laravel API:', error.response ? error.response.data : error.message);
        // console.error('Error calling Laravel API:', error.response ? error.response.data : error.message);
      }

});
app.get('/blocks/gen-key', (req, res)=>{
    try {
        var key = generateKeys();
        res.status(200).json(key);
    }
    catch (error){
        res.status(200).json({status:false, messages:"Tạo key thất bại"});
    }
})
// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
