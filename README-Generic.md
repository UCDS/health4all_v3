PreLogin
    Login Form --> (validation)
    Forgot password Form --> (validation + update)
    Sign up Form --> (validation + create)

PostLogin
    - Any Module (Hospital/Priority/Route)
        - Form  --> (Validation + Create/Update)
            - controller
                - title
                - actionType
                - common/form_page.php
                - rules[{name, label, rules}]
                - success={{title}} {{action}} successfully
                - failure={{title}} could not be added. Please try again.
        - Confirmation  --> (Delete)
        - Display --> (Table + Chart + KeyValuePairs Sections)
        - DependentField --> (load another data based on passed data)
