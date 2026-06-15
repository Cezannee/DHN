<?php

return [
    'setting_fields' => [
        'app' => [
            'title' => 'General',
            'desc' => 'All the general settings for application.',
            'icon' => 'fas fa-cube',

            'elements' => [
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'app_name', // unique name for field
                    'label' => 'App Name', // you know what label it is
                    'rules' => 'required|min:2|max:50', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'Digi Herba Nusantara', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'app_description', // unique name for field
                    'label' => 'App Description', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'We are a company specializing in the distribution of herbal and organic products..', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'footer_text', // unique name for field
                    'label' => 'Footer Text', // you know what label it is
                    'rules' => 'required|min:2', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'Digi Herba Nusantara', // default value if you want
                ],
                [
                    'type' => 'checkbox', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'show_credit', // unique name for field
                    'label' => 'Show Credit', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '1', // default value if you want
                ],
                [
                    'type' => 'checkbox', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'show_license', // unique name for field
                    'label' => 'Show License', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '1', // default value if you want
                ],
                [
                    'type' => 'radio', // input fields type
                    'data' => 'boolean', // data type, string, int, boolean
                    'name' => 'show_language_dropdown', // unique name for field
                    'label' => 'Show Language Dropdown', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '1', // default value if you want
                    'options' => [
                        '1' => 'Show',
                        '0' => 'Hide',
                    ],
                    'help' => 'Show or hide the language selection dropdown in both frontend and backend.', // Help text for the input field.
                ],
                [
                    'type' => 'radio', // input fields type
                    'data' => 'boolean', // data type, string, int, boolean
                    'name' => 'show_theme_dropdown', // unique name for field
                    'label' => 'Show Theme Dropdown', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '1', // default value if you want
                    'options' => [
                        '1' => 'Show',
                        '0' => 'Hide',
                    ],
                    'help' => 'Show or hide the theme selection dropdown in both frontend and backend.', // Help text for the input field.
                ],
            ],
        ],
        'home' => [
            'title' => 'Home',
            'desc' => 'Media shown on the public home page.',
            'icon' => 'fa-solid fa-house',

            'elements' => [
                [
                    'type' => 'media-list',
                    'data' => 'text',
                    'name' => 'home_background_media',
                    'label' => 'Home Background Media',
                    'rules' => 'nullable|string',
                    'class' => '',
                    'value' => '',
                    'media' => 'mixed',
                    'directories' => [
                        'background',
                    ],
                    'upload' => true,
                    'upload_name' => 'home_background_media_uploads',
                    'upload_directory' => 'background',
                    'help' => 'Pilih gambar atau video lokal untuk background home. Satu path per baris. Mendukung: jpg, jpeg, png, gif, webp, svg, mp4, webm, ogg.',
                ],
                [
                    'type' => 'media-list',
                    'data' => 'text',
                    'name' => 'home_gallery_images',
                    'label' => 'Galeri Produk',
                    'rules' => 'nullable|string',
                    'class' => '',
                    'value' => '',
                    'media' => 'image',
                    'directories' => [
                        'galeri produk',
                    ],
                    'upload' => true,
                    'upload_name' => 'home_gallery_images_uploads',
                    'upload_directory' => 'galeri produk',
                    'help' => 'Pilih atau upload foto galeri produk yang tampil di halaman home. File baru disimpan ke folder public/galeri produk. Satu path gambar per baris.',
                ],
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'marketplace_shopee_url',
                    'label' => 'Shopee URL',
                    'rules' => 'nullable|max:2048',
                    'class' => '',
                    'value' => '',
                    'help' => 'Link toko Shopee yang tampil pada tombol Belanja Sekarang.',
                ],
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'marketplace_tokopedia_url',
                    'label' => 'Tokopedia URL',
                    'rules' => 'nullable|max:2048',
                    'class' => '',
                    'value' => '',
                    'help' => 'Link toko Tokopedia yang tampil pada tombol Belanja Sekarang.',
                ],
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'marketplace_tiktokshop_url',
                    'label' => 'TikTok Shop URL',
                    'rules' => 'nullable|max:2048',
                    'class' => '',
                    'value' => '',
                    'help' => 'Link toko TikTok Shop yang tampil pada tombol Belanja Sekarang.',
                ],
            ],
        ],
        'contact' => [
            'title' => 'Contact',
            'desc' => 'Contact information and public contact form settings.',
            'icon' => 'fa-solid fa-address-book',

            'elements' => [
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'contact_section_title',
                    'label' => 'Contact Section Title',
                    'rules' => 'nullable|max:120',
                    'class' => '',
                    'value' => 'Halaman Kontak',
                    'help' => 'Judul yang tampil pada bagian kontak di halaman home.',
                ],
                [
                    'type' => 'textarea',
                    'data' => 'text',
                    'name' => 'contact_section_description',
                    'label' => 'Contact Section Description',
                    'rules' => 'nullable|string',
                    'class' => '',
                    'value' => 'Hubungi kami untuk informasi produk, kerja sama, atau pertanyaan lainnya.',
                    'help' => 'Deskripsi singkat yang tampil di bawah judul kontak.',
                ],
                [
                    'type' => 'textarea',
                    'data' => 'text',
                    'name' => 'contact_address',
                    'label' => 'Address',
                    'rules' => 'nullable|string',
                    'class' => '',
                    'value' => '',
                    'help' => 'Alamat lengkap yang tampil di halaman kontak.',
                ],
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'contact_phone',
                    'label' => 'Contact Number',
                    'rules' => 'nullable|max:50',
                    'class' => '',
                    'value' => '',
                    'help' => 'Nomor telepon atau WhatsApp yang tampil di halaman kontak.',
                ],
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'contact_email',
                    'label' => 'Contact Email',
                    'rules' => 'nullable|email|max:2048',
                    'class' => '',
                    'value' => '',
                    'help' => 'Email publik yang tampil di halaman kontak.',
                ],
                [
                    'type' => 'text',
                    'data' => 'string',
                    'name' => 'contact_form_recipient_email',
                    'label' => 'Contact Form Recipient Email',
                    'rules' => 'nullable|email|max:2048',
                    'class' => '',
                    'value' => '',
                    'help' => 'Email tujuan untuk menerima pesan dari form kontak. Jika kosong, sistem memakai Contact Email atau Email utama aplikasi.',
                ],
            ],
        ],
        'email' => [
            'title' => 'Email',
            'desc' => 'Email settings for app',
            'icon' => 'fas fa-envelope',

            'elements' => [
                [
                    'type' => 'email', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'email', // unique name for field
                    'label' => 'Email', // you know what label it is
                    'rules' => 'required|email', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'info@example.com', // default value if you want
                ],
            ],

        ],
        'social' => [
            'title' => 'Social Profiles',
            'desc' => 'Link of all the online/social profiles.',
            'icon' => 'fas fa-users',

            'elements' => [
                [
                    'type' => 'radio', // input fields type
                    'data' => 'boolean', // data type, string, int, boolean
                    'name' => 'show_footer_social_profiles', // unique name for field
                    'label' => 'Show Footer Social Profiles', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '1', // default value if you want
                    'options' => [
                        '1' => 'Show',
                        '0' => 'Hide',
                    ],
                    'help' => 'Show or hide the footer social profiles in frontend.', // Help text for the input field.
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'website_url', // unique name for field
                    'label' => 'Website URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'facebook_url', // unique name for field
                    'label' => 'Facebook Page URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'twitter_url', // unique name for field
                    'label' => 'Twitter Profile URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'instagram_url', // unique name for field
                    'label' => 'Instagram Account URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'youtube_url', // unique name for field
                    'label' => 'Youtube Channel URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'linkedin_url', // unique name for field
                    'label' => 'LinkedIn URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'whatsapp_url', // unique name for field
                    'label' => 'WhatsApp URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'messenger_url', // unique name for field
                    'label' => 'Messenger URL', // you know what label it is
                    'rules' => 'nullable|max:191', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
            ],

        ],
        'meta' => [
            'title' => 'Meta ',
            'desc' => 'Application Meta Data',
            'icon' => 'fa-solid fa-earth-asia',

            'elements' => [
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_site_name', // unique name for field
                    'label' => 'Meta Site Name', // you know what label it is
                    'rules' => 'required', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'Digi Herba Nusantara', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_description', // unique name for field
                    'label' => 'Meta Description', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'We are a company specializing in the distribution of herbal and organic products.', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_keyword', // unique name for field
                    'label' => 'Meta Keyword', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'Digi Herba Nusantara, herbal, organic products', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_image', // unique name for field
                    'label' => 'Meta Image', // you know what label it is
                    'rules' => 'required', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'img/default_banner.jpg', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_fb_app_id', // unique name for field
                    'label' => 'Meta Facebook App Id', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '569561286532601', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_twitter_site', // unique name for field
                    'label' => 'Meta Twitter Site Account', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'meta_twitter_creator', // unique name for field
                    'label' => 'Meta Twitter Creator Account', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                ],
            ],
        ],
        'analytics' => [
            'title' => 'Analytics',
            'desc' => 'Application Analytics',
            'icon' => 'fas fa-chart-line',

            'elements' => [
                [
                    'type' => 'text', // input fields type
                    'data' => 'text', // data type, string, int, boolean
                    'name' => 'google_analytics', // unique name for field
                    'label' => 'Google Analytics (gtag)', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => 'G-ABCDE12345', // default value if you want
                    'help' => 'Paste the only the Measurement Id of Google Analytics stream.', // Help text for the input field.
                ],
            ],

        ],
        'custom_css' => [
            'title' => 'Custom Code',
            'desc' => 'Custom code area',
            'icon' => 'fa-solid fa-file-code',

            'elements' => [
                [
                    'type' => 'textarea', // input fields type
                    'data' => 'string', // data type, string, int, boolean
                    'name' => 'custom_css_block', // unique name for field
                    'label' => 'Custom Css Code', // you know what label it is
                    'rules' => 'nullable', // validation rule of laravel
                    'class' => '', // any class for input
                    'value' => '', // default value if you want
                    'help' => 'Paste the code in this field.', // Help text for the input field.
                    'display' => 'raw', // Help text for the input field.
                ],
            ],

        ],
    ],
];
