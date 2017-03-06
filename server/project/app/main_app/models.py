from django.db import models

def increment():

	get_parking_lot().number_of_filled_spots += 1

def decrement():

	parking_lot = get_parking_lot()

	get_parking_lot().number_of_filled_spots -= 1


def get_parking_lot():

	return EnclosedParkingLot.objects.all()[0]


class ParkingGroup(models.Model):

	name = models.CharField(max_length=256)


class EnclosedParkingLot(models.Model):

	group = models.ForeignKey(ParkingGroup)
	name = models.CharField(max_length=256)
	number = models.PositiveIntegerField(unique=True)
	total_capacity = models.PositiveIntegerField()
	number_of_filled_spots = models.PositiveIntegerField(default=0)
