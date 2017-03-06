import requests
#import picamera
import time

FRAMES_PER_SECOND = 5
URL = 'http://54.187.124.2:8000/app/post/'
SLEEP_TIME = 1.0/FRAMES_PER_SECOND


def get_filename(number):

    return str(number) + ".png"


# enable camera
#camera = picamera.PiCamera()

# infinite loop, each iteration = one second
while True:

    # take X number of shots
    for i in range(FRAMES_PER_SECOND):

        #camera.capture(get_filename(i))
        time.sleep(SLEEP_TIME)

    files = {"img":open('test_image.jpg', 'rb')}
    
    # HTTP request
    response = requests.post(URL, files=files)
