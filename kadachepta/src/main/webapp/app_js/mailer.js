'use strict';
const nodemailer = require('nodemailer');

// create reusable transporter object using the default SMTP transport
let transporter = nodemailer.createTransport({
    host: 'mail.kadachepta.com',
    port: 465,
    secure: true, // secure:true for port 465, secure:false for port 587
    auth: {
        user: 'yourstruly@kadachepta.com',
        pass: 'Torpedo#1'
    }
});

// setup email data with unicode symbols
let mailOptions = {
    from: '"Portal Admin" <yourstruly@kadachepta.com>', // sender address
    to: 'yourstruly@kadachepta.com', // list of receivers
    subject: 'Tring Tring! Exciting story is up for review!', // Subject line
    text: 'Review and publish the story ASAP.. Poeple are waiting for new stories!! ', // plain text body
    html: '<b>' + text + '</b>' // html body
};

// send mail with defined transport object
//transporter.sendMail(mailOptions, (error, info) => {
//    if (error) {
//        return console.log(error);
//    }
//    console.log('Message %s sent: %s', info.messageId, info.response);
//});
modules.export = transporter;