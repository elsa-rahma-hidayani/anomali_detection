const nodemailer = require('nodemailer');
const fs = require('fs');

// Ambil argumen dari command line
const [,, toEmail, subject, htmlContent] = process.argv;

console.log(`To: ${toEmail}`);
console.log(`Subject: ${subject}`);
console.log(`Content: ${htmlContent}`);

// Konfigurasi transporter Nodemailer
let transporter = nodemailer.createTransport({
    service: 'gmail', // Anda dapat mengganti dengan penyedia email lain jika perlu
    auth: {
        user: 'testerprogram69@gmail.com',
        pass: 'quutydjperztxhnr'
    }
});

// Opsi email
let mailOptions = {
    from: 'testerprogram69@gmail.com',
    to: toEmail,
    subject: subject,
    html: htmlContent
};

// Kirim email
transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
        console.log('Error: ', error);
        fs.writeFileSync('error_log.txt', JSON.stringify(error, null, 2));
        process.exit(1); // Kode kesalahan 1 jika terjadi error
    } else {
        console.log('Email sent: ' + info.response);
        process.exit(0); // Kode sukses 0 jika email terkirim
    }
});
