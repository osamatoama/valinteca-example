def handle_success(success_message: str) -> None:
    # implement success api call here
    print("making success api call")
    

def handle_failure(error_message: str) -> None:
    # implement failure api call here
    print('failure handler')


def unknown_error(error_message: str) -> None:
    # implemen api logic
    print('making error api call: "unknown error"')
    print("error: ",str(error_message))