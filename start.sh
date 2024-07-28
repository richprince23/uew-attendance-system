# Navigate to the project directory
cd '/Volumes/STORAGE/PROJECTS/ADV SOFTWARE/'

# Activate Python virtual environment and run the Python server in the background
source microservice/.venv/bin/activate
python microservice/app.py --reload &

# Navigate to the Laravel project directory and start the PHP server
cd uew-attendance-system
php artisan serve
