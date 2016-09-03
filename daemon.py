#!/usr/bin/env python

import argparse, sqlite3, serial, pyowm, random

parser = argparse.ArgumentParser(description='Daemon that aggregates weather data from arduino and the web and makes a recommendation.')
args = parser.parse_args()

ser = serial.Serial('/dev/cu.usbmodem1421', 9600)

db = sqlite3.connect('weather.db')
db.cursor().execute(
    'create table if not exists sensor ('
    'light integer, humidity_ground integer, humidity_air integer, temperature integer, created_at datetime DEFAULT CURRENT_TIMESTAMP'
')')
try:
    count = 0
    while True:
        data = ser.readline().strip()
        print(data)
        if data:
            count += 1
            try:
                split = map(lambda x: int(float(x)), data.split())
                db.cursor().execute('insert into sensor (light, humidity_ground, humidity_air, temperature) values(?, ?, ? ,?)', (
                    split[0], # light
                    split[1], # humidity
                    split[2], # air humidity
                    split[3], # temperature
                ))
                if count % 10 == 0:
                    db.commit()
                    count = 0
            except sqlite3.Error as e:
                print "[sqlite3 error] ", e.args[0]

except KeyboardInterrupt:
    db.close()
