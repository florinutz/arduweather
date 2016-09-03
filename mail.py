import serial
import smtplib
import yaml

config = yaml.safe_load(open('config.yml'))

to = config['receiver_email']
gmail_user = config['gmail_user']
gmail_pass = config['gmail_pass']

subject = 'Water your plants'
text = 'Please water your plants. The soil is dry.'

ser = serial.Serial(config['serial_port'], 9600)

def send_email():
    smtpserver = smtplib.SMTP_SSL('smtp.gmail.com', 465)
    smtpserver.login(gmail_user, gmail_pass)
    header = 'To:' + to + '\n' + 'From: ' + gmail_user
    header = header + '\n' + 'Subject:' + subject + '\n'
    print header
    msg = header + '\n' + text + ' \n\n'
    smtpserver.sendmail(gmail_user, to, msg)
    smtpserver.close()

while True:
    value = int(ser.readline().rstrip('\r\n'))
    print(value)
    print repr(value)
    if value < 500:
        print('Sent email')
        send_email()
        value = 1023