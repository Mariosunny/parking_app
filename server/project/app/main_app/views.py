from django.http import JsonResponse
from django.views.decorators.csrf import csrf_exempt

from . import models


def get(request):

	parking_lot_data = {}

	for parking_lot in models.EnclosedParkingLot.objects.all():

		parking_lot_data.update({

			parking_lot.number: {
				"total_capacity": parking_lot.total_capacity,
				"number_of_filled_spots": parking_lot.number_of_filled_spots,
			}	
		})

	return JsonResponse(parking_lot_data)

@csrf_exempt
def post(request):

	pass