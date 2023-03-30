const express = require('express')
const app = express()
const port = 8889

app.use(express.json())

app.get('/product', (req, res) => {
    res.json({
        "ok" : true
    })
})

app.listen(port, () => {
    console.log('App listening at http://localhost:${port}')
})