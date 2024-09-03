const nodemailer = require('nodemailer');
const Mailgen = require('mailgen');

// Ambil argumen dari command line
const [,, toEmail, resetToken] = process.argv;

// Konfigurasi transporter Nodemailer
let transporter = nodemailer.createTransport({
    service: 'gmail',
    auth: {
        user: 'testerprogram69@gmail.com',
        pass: 'quutydjperztxhnr'
    }
});

// Konfigurasi Mailgen
let MailGenerator = new Mailgen({
    theme: "default",
    product: {
        name: "Layanan Aplikasi Blablabla",
        link: 'http://localhost'
    }
});

// Isi email
let email = {
    body: {
        name: "Broski",
        intro: "Kami menerima permintaan untuk mereset password Anda. Silakan klik link di bawah ini untuk mengatur ulang password Anda.",
        action: {
            instructions: 'Klik tombol berikut untuk mengatur ulang password Anda:',
            button: {
                color: '#22BC66',
                text: 'Reset Password',
                link: `http://localhost/anomali_detection/reset_password.php?token=${resetToken}`
            }
        },
        outro: 'Jika Anda tidak meminta reset password, abaikan email ini.'
    }
};

// Generate HTML email dengan Mailgen
let emailBody = MailGenerator.generate(email);

// Opsi email
let mailOptions = {
    from: 'testerprogram69@gmail.com',
    to: toEmail,
    subject: 'Reset Password',
    html: emailBody
};

// Kirim email
transporter.sendMail(mailOptions, (error, info) => {
    if (error) {
        console.error('Error occurred: ', error);
        process.exit(1); // Exit dengan kode error
    } else {
        console.log('Email sent: ' + info.response);
        process.exit(0); // Exit dengan kode sukses
    }
});
