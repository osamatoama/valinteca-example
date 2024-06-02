from src.core import process
from src import api
import time

# Current Codes:
# 90807456
# 10510253
# 99561028
# 10411555
# 51120102
# 84566789
# 11310877
# 68877352
# 73110801
# 10710612



def main():
    # initial data from api
    razer_email = '10DonAbdullah@gmail.com'
    razer_password = 'ASDFasdf12'

    active_backup_code = '81881219'

    try:
        time.sleep(5)
        result = process(razer_email=razer_email, razer_password=razer_password, initial_backup_code=active_backup_code)
        print(result)
        api.handle_success(success_message=result)
    except Exception as error:
        print(error)
        api.handle_failure(error_message=error)


if __name__=='__main__':
    main()
