from fabric.api import *
from fabric.state import *
import time


class FabricException(Exception):

    pass


env.user = "ubuntu"
env.hosts = ["54.244.77.137"]
env.key_filename = "./../../parking_app_key.pem"
output.running = False
output.stdout = True
output.stderr = True
output.status = False
output.aborts = False
server_root = "~/parking_app"
erase_data_phrase = "confirm erase"
database_path = "project/app/db.sqlite3"
env.abort_exception = FabricException
current_time = lambda: int(round(time.time() * 1000))


def start_server():

	print("Starting server.")


def stop_server():

	print("Stopping server.")


def perform_checks():

	print("Checking status of local project.")

	git_status = local("git fetch")

	if git_status:

		print("Your local repository is not up to date. You must have the latest version of the project in order to upload it to the server.")

		return False

	print("Status: OK.")
	return True


def backup():

	print("Creating backup.")

	try: run("rm -r backup")
	except: pass

	run("mkdir backup")
	run("cp -r project/* backup/")


def cleanup():

	print("Cleaning up.")
	
	try: run("rm project.zip")
	except: pass

	try: local("rm project.zip")
	except: pass

	try: run("rm -r backup/")
	except: pass

	try: run("deactivate")
	except: pass

	start_server()


def intialize():

	try: run("mkdir backup")
	except: pass

# options: wipe, replace
def deploy(option=None):

	if not (option == None or option == "wipe" or option == "replace"):

		print("Invalid option. options: wipe, replace")
		return

	if not perform_checks():

		return

	if option:

		print("WARNING: You have chosen to erase all data on the server. This operation cannot be undone.")
		erase_data_phrase_attempt = prompt("Enter the phrase '" + erase_data_phrase + "' to continue:")

		if erase_data_phrase_attempt != erase_data_phrase:

			print("Incorrect phrase. Aborting.")
			return

	print("Beginning deployment.")
	begin_time = current_time()
	stop_server()
	
	with cd(server_root):

		try:

			intialize()

			print("Compressing local project.")
			local("zip -r project.zip project/")

			print("Uploading project to server.")
			put("project.zip", server_root)

			backup()

			print("Removing old project.")
			run("rm -r project/")

			print("Inflating new project.")
			run("unzip project.zip")

			if option == None:

				print("Restoring database.")
				run("cp backup/app/db.sqlite3 " + database_path)

			elif option == 'wipe':

				run("rm " + database_path)

			print("Applying database migrations.")
			run("python3 ./project/app/manage.py migrate")

		except FabricException:

			print("Deployment failed.")
			cleanup()
			return

	cleanup()

	print("Deployment successful. Completed in " + ("%.1f" % ((current_time() - begin_time)/1000.0)) + " seconds.")
