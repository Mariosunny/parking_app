from collections import namedtuple

Event = namedtuple('Event', ['laser', 'state'])





for line in range(int(input())):

	input_data.append(Event(int(line[0]), True if int(line[1]) == 1 else False))


def check_state():

	for event in event_queue[::-1]:

		if event.laser == 0:


