const express = require('express');
const axios = require('axios');

const app = express();
const PORT = 3000;

app.get('/users', async (req, res) => {
    try {
        const response = await axios.get('http://localhost/shoppingcart/Q6/api.php');
        res.json(response.data);
    } catch (error) {
        res.status(500).json({ error: 'Failed to fetch data' });
    }
});

app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
