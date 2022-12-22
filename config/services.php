<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'firebase' => [
        'database_url' => 'ajiriwa-push-notifications.firebaseapp.com',
        'project_id' =>"ajiriwa-push-notifications",
        'private_key_id' => "b9538add6a9b1ecf89c57d2070dc6105eb85c67f",
        // replacement needed to get a multiline private key from .env
        'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCqXzcMcbCaSpOO\nM9P7TU8mgSHDvOcnmDVDyfSWVVzVHRIGtXRjhb2K845KVCs6n2fr3cZZtUBDKaEp\nkTWJuh7P9cRvE+28ScLuuvWwBEuCsDvga5W02/kYhPk3mHII83SHWSEnyYvyGRw3\n+w2hUA5uvuLbNiDCqek13irimE11wHasmXaxslofqqThLmz6/ZDpy9cgX7zzo/7X\nm2N+nRgg8WL3WtQ21Jg2ENABcsjDQleLC4JI4fNa2SyGAqLXwqmQuKosUySVxX2q\n4VvAh+k9GhDJxP1eeV4Mk5MtqgddYQleBDdDMHbnktcc8c0u/otvVkHl+3vFLj0U\n//2p7kfRAgMBAAECggEAEj8Dw4Cqh/+sKVraHUwUibxjLBYfUHF/5NxsZixKtqU4\nIMFOr3jriYXXi5TTk2HujIdyHnnnobnD4ZKEYBVvhticmsPQ3m0s5AngVaNEHgE3\nTGvhOt8jIJHfKenY7qX6KSOtxhfS9dDkIYew2EGdZhVp8M2teQOe7w6125Ixm4Ze\nM1pSt7QU1W7HijHHYnGJomId3SSIHo+ogQBJMT+pMHUic+PyMIjdN3DsNtUHqVgD\nu8wHMUkhrY6hP/ERncmbKZqmfR9QDkgH3WtQY6C/OhVuETF2IMbZzRc768hfhZZW\nDANhfnQNRfhV+B0GGbT4Y/ouGm6imCt5hVHHRu2AsQKBgQDcSVI7yA9UxCS1zLZT\nGb7cbuwjj9k67QR5llGmSTyIv14DNu575r3amF8jZ9XtiE0qX8XwV0BUvbVIcq+B\n1yoS3iyJJkm+N02ZLihugfLlek2lFuxlXBiXjXKD0djaIm0veYaPq5dGKNhamJ72\nneqAVgPp8ofRJM4XzmWB6+Kc6QKBgQDF/kNs2B5WVnn/toKjnWNuY7QwOOkDjxat\nhnyDOR8ANVSRzUQC37PCkww5RRpx3L+vVRj7ORSmYo1aRm5YZuySPW/ixW5FRljP\nw0iMjgH+j3u+klHPxy6TWCWEuwMNceMdKirb6SI9xkPy8JiaxyE5nSvvDGZ4nnVL\nHZ1CzvfiqQKBgA0I8arD7dRQPvPbBzbnoRmeHq8EBhCskcU4FeDHGKPm3wNFrtr6\nDmXu+kI4FLqXhClrvWS5ZP8esql0z9nZB45SQ0RiVZ7B2v+jcZUIb30QvaN1NcvR\npUrifdI7Cp/txZQ3lrTNrIfkRtklitKBCa1KabTgOxUvHlreRbdoY+JxAoGAK7yA\nDnIrOW0+4+LgNt5UkZUKv8BCkNux6cEUjjQ3Cee997s9M9lQr0GmaJxAPDjESynk\nK9KvIhYRHYkDZRnPVnql1ZVBR6JDihmcVBgmjqIJds6BrgFU442MNCbPhM/MmKuw\n7gUw4C6E4gyN2Vr1lvGGO/ckR67RQDeZfqGTlokCgYAaUmfkJjR9fAjk5dHQJwtM\nTlaNAVJPJ5JOMcNa3LIErdxygMIWowqGjB10xCAsskuHK8g6+p8IU7ABSipn6m8T\nEy1C0WXUuAc0Wm+Xxynu4bsSv042yfF4CNuwYn5Ms0G5R4Txg+PO/BP6Th3+OssS\n4sPhkTrVeNV3mysU2kq7SQ==\n-----END PRIVATE KEY-----\n",
        'client_email' => "firebase-adminsdk-knwvh@ajiriwa-push-notifications.iam.gserviceaccount.com",
        'client_id' => "114182168357160307922",
        'client_x509_cert_url' => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-knwvh%40ajiriwa-push-notifications.iam.gserviceaccount.com",
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => 'http://127.0.0.1:8000/auth/linkedin/callback',
    ],
    'facebook' => [
        'client_id' => '', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'client_secret' => '', //USE FROM FACEBOOK DEVELOPER ACCOUNT
        'redirect' => 'https://examplelaravel8.test/facebook/callback/'
    ],
];
