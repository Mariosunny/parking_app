import numpy as np
import cv2
cv2.ocl.setUseOpenCL(False)


car_cascade = cv2.CascadeClassifier('cascades/carcascade4.xml')
i=1
while i<6:
    cap = cv2.VideoCapture("videos/low_res_tests"+str(i)+".mp4")
    count=0
    county=0
    countys=0
    carsin=0
    carsout=0
    prev_x=0
    a=100
    b=220
    first=0
    while True:
        ret, img = cap.read()
    
        if (type(img) == type(None)):
            break
        
        blur = cv2.GaussianBlur(img,(3,3),0)
        cars = car_cascade.detectMultiScale(blur,1.1,3)
        cv2.line(img, (a, 0),(a,400),  (250,0,0),2)
        cv2.line(img, (b, 0),(b,400),  (250,0,0),2)
        for (x,y,w,h) in cars[0:2]:
            if x>a and x<b :
                prev_x=x
                countys = count
                cv2.rectangle(img,(x,50),(x+100,120),(0,250,0),2)
                carsin += 1
            else:
                countys=0
            print(str(prev_x) + " " + str(x))
            
        cv2.imshow('video', img)
        count += 1
                
        if cv2.waitKey(33) == 27:
            break
    countys = 0
    prev_x=0
    i += 1   
    print(str(count) + " frames, " + str(carsin) + " car(s) in" + str(carsout) + " car(s) out")
    
cv2.destroyAllWindows()
