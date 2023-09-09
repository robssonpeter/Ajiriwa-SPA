# Candidate Application
This is the new page for making application. Its created as an alternative to the apply function in the Jobs Page when the user is signed in

## Form Fields
- **Cover Letter** - This is optional depending on the specification of the job
- **Attachments** - User can will be able to select attachement from a selection input, a user woul like to add another attachment they can simply click the manage attachment link and the system will remember their entered details then take them to the attachments management page.
- **Assessement Questions ** - These are the preconfigured questions for assessment that the user has go to answer in order to proceed.

## Dev
In this page two session variables are managed ```session()->get('remembered_application')``` and ```session()->get('return_to_link')```