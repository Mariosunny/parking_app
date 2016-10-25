# -*- coding: utf-8 -*-
import numpy as np
import cv2
cv2.ocl.setUseOpenCL(False)

#cascade_src = 'cars.xml'
#video_src = 'dataset/test3.mp4'

cap = cv2.VideoCapture("test.mp4")
fgbg = cv2.createBackgroundSubtractorMOG2()
car_cascade = cv2.CascadeClassifier("carcascade4.xml")


while True:
    ret, img = cap.read()
    
    if (type(img) == type(None)):
        break
    fgmask = fgbg.apply(img)
    gray = cv2.cvtColor(fgmask, cv2.COLOR_BGR2GRAY)
    blur = cv2.GaussianBlur(gray,(15,15),0)
    cars = car_cascade.detectMultiScale(blur, 1.5, 3)

    for (x,y,w,h) in cars:
        cv2.rectangle(img,(x,y),(x+w,y+h),(0,250,0),2)      
    
    cv2.imshow('video', img)
    if cv2.waitKey(33) == 27:
        break

cv2.destroyAllWindows()
