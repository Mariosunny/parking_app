from django.conf.urls import url, include

from . import views

urlpatterns = [

    url(r'^app/', include([

    	url(r'^get/$', views.get, name='get'),
    	url(r'^post/$', views.post, name='post'),
    ], namespace="app")),
]