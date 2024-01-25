# User Setting
This is where all the user settings are going to be stored. It is put at the user level so 
any setting that is stored here is only applicable to a specify user.

## Setting Keys
- ```default_application_rejection_template```  used to define the default template to use on sending an rejection email. Typically when an application is marked as rejected. Derived from the type of the email template then adding ```default_``` and ```_template``` on the sides
- ```default_interview_schedule_template``` when interview is scheduled the candidate will be notified using this template if set as default