const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const app = express();

app.use(bodyParser.json({ extended: true }));
app.use(cors());

app.post('/kce_notif', (req, res) => {
// app.get('/kce_notif', (req, res) => {

  var msg = req.body;
  const serialportgsm = require('serialport-gsm');

  var gsmModem = serialportgsm.Modem();
  let options = {
   baudRate: 115200,
   dataBits: 8,
   parity: 'none',
   stopBits: 1,
   xon: false,
   rtscts: false,
   xoff: false,
   xany: false,
   autoDeleteOnReceive: true,
   enableConcatenation: true,
   incomingCallIndication: true,
   incomingSMSIndication: true,
   pin: '',
   customInitCommand: 'AT^CURC=0',
   logger: console
  }

  let phone = {
   name: "Dioame",
   number: "+639467105070",
   numberSelf: "+639128321289",
   mode: "PDU",
   msg: msg.content,
   contacts: msg.contact,
  }

  // Port is opened
  gsmModem.on('open', () => {
   console.log(`Modem Sucessfully Opened`);

   // now we initialize the GSM Modem
   gsmModem.initializeModem((msg, err) => {
     if (err) {
       console.log(`Error Initializing Modem - ${err}`);
     } else {
       console.log(`InitModemResponse: ${JSON.stringify(msg)}`);

       console.log(`Configuring Modem for Mode: ${phone.mode}`);
       // set mode to PDU mode to handle SMS
       gsmModem.setModemMode((msg,err) => {
         if (err) {
           console.log(`Error Setting Modem Mode - ${err}`);
         } else {
           console.log(`Set Mode: ${JSON.stringify(msg)}`);

           // get the Network signal strength
           gsmModem.getNetworkSignal((result, err) => {
             if (err) {
               console.log(`Error retrieving Signal Strength - ${err}`);
             } else {
               console.log(`Signal Strength: ${JSON.stringify(result)}`);
             }
           });

           // get Modem Serial Number
           gsmModem.getModemSerial((result, err) => {
             if (err) {
               console.log(`Error retrieving ModemSerial - ${err}`);
             } else {
               console.log(`Modem Serial: ${JSON.stringify(result)}`);
             }
           });

          // get the Own Number of the Modem
           // gsmModem.getOwnNumber((result, err) => {
           //   if (err) {
           //     console.log(`Error retrieving own Number - ${err}`);
           //   } else {
           //     console.log(`Own number: ${JSON.stringify(result)}`);
           //   }
           // });

           // execute a custom command - one line response normally is handled automatically
           gsmModem.executeCommand('AT^GETPORTMODE', (result, err) => {
             if (err) {
               console.log(`Error - ${err}`);
             } else {
               console.log(`Result ${JSON.stringify(result)}`);
             }
           });

           // execute a complex custom command - multi line responses needs own parsing logic
           const commandParser = gsmModem.executeCommand('AT^SETPORT=?', (result, err) => {
             if (err) {
               console.log(`Error - ${err}`);
             } else {
               console.log(`Result ${JSON.stringify(result)}`);
             }
           });

           const portList = {};
           commandParser.logic = (dataLine) => {
             if (dataLine.startsWith('^SETPORT:')) {
               const arr = dataLine.split(':');
               portList[arr[1]] = arr[2].trim();
             }
             else if (dataLine.includes('OK')) {
               return {
                 resultData: {
                   status: 'success',
                   request: 'executeCommand',
                   data: { 'result': portList }
                 },
                 returnResult: true
               }
             }
             else if (dataLine.includes('ERROR') || dataLine.includes('COMMAND NOT SUPPORT')) {
               return {
                 resultData: {
                   status: 'ERROR',
                   request: 'executeCommand',
                   data: `Execute Command returned Error: ${dataLine}`
                 },
                 returnResult: true
               }
             }
           };
         }
       }, phone.mode);
         // get info about stored Messages on SIM card
         gsmModem.checkSimMemory((result, err) => {
           if(err) {
             console.log(`Failed to get SimMemory ${err}`);
           } else {
             console.log(`Sim Memory Result: ${JSON.stringify(result)}`);

             // read the whole SIM card inbox
             gsmModem.getSimInbox((result, err) => {
               if(err) {
                 console.log(`Failed to get SimInbox ${err}`);
               } else {
                 console.log(`Sim Inbox Result: ${JSON.stringify(result)}`);
               }

              // Finally send an SMS
              // var n = ['+639272677689','+639568625630','+639272677689'];
              
              for(var i=0;i<phone.contacts.length;i++){
                const message = phone.msg;

                gsmModem.sendSMS(phone.contacts[i], message, false, (result) => {
                 console.log(`Callback Send: Message ID: ${result.data.messageId},` +
                     `${result.data.response} To: ${result.data.recipient} ${JSON.stringify(result)}`);
                });
              }
              //

             });

           }
         });
         // end get info about stored Messages on SIM card
     }
     // end if else


   });
   // end initializeModem

  });
  // end Port is opened

gsmModem.open('COM6', options);

setTimeout(() => {
 gsmModem.close(() => process.exit);
}, 5000);

});

const port = 4500;

app.listen(port, () => {
  console.log('Server Listening on '+port);
});
