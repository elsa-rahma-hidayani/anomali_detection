const nodemailer = require('nodemailer');
const fs = require('fs');
const querystring = require('querystring');

// Ambil argumen dari command line
const [,, toEmail, subject, encodedHtmlContent] = process.argv;

// Decode HTML content
const htmlContent = querystring.unescape(encodedHtmlContent);

console.log(`To: ${toEmail}`);
console.log(`Subject: ${subject}`);
console.log(`Content: ${htmlContent}`);

// Konfigurasi transporter Nodemailer
let transporter = nodemailer.createTransport({
    service: 'gmail', // Anda dapat mengganti dengan penyedia email lain jika perlu
    auth: {
        user: 'testerprogram69@gmail.com', // Ganti dengan email Anda
        pass: 'quutydjperztxhnr' // Ganti dengan password email atau app password Anda
    }
});

// Opsi email
let mailOptions = {
    from: 'testerprogram69@gmail.com', // Ganti dengan email Anda
    to: toEmail,
    subject: subject,
    html: htmlContent
};

// Tambahkan logging untuk debugging lebih mendalam
console.log("Starting email send process...");

transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
        console.error('Error occurred: ', error);
        fs.writeFileSync('detailed_error_log.txt', JSON.stringify(error, null, 2));
        process.exit(1); // Exit dengan kode error
    } else {
        console.log('Email sent: ' + info.response);
        fs.writeFileSync('send_success_log.txt', JSON.stringify(info, null, 2));
        process.exit(0); // Exit dengan kode sukses
    }
});
