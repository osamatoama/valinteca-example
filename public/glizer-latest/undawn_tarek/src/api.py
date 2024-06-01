def handle_success(success_message: str) -> None:
    # implement success api call here
    print("making success api call")
    

def handle_failure(error_message: str) -> None:    
    print('failure handler')


def invalid_player_id(error_message: str) -> None:
    # implemen api logic
    print('making error api call:  api.invalid_player_id')


def unknown_error(error_message: str) -> None:
    # implemen api logic
    print('making error api call: "unknown error"')
    print("error: ",str(error_message))