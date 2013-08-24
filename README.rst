AlexWebBundle
=============

STILL IN DEVELOPMENT - **You need to duplicates repositories from composer.json
to your composer.json and have minimum stability to dev in order to use this
bundle**

Installation
------------


Add **alexandresalome/web-bundle** to your **composer.json**:

.. code-block:: json

    {
        "require": {
            "alexandresalome/web-bundle": "dev-master"
        }
    }

Updates your dependencies and add it to your **AppKernel**:

.. code-block:: php

    public function registerBundles()
    {
        return array(
            // ...

            new Alex\WebBundle\AlexWebBundle()
        )
    }

In ``config.yml``, add the bundle to **assetic configuration**:

.. code-block:: yaml

    assetic:
        bundles:        [ AlexWebBundle ]

Finally in Twig configuration, add form templating:

    twig:
        form:
            resources: [ "AlexWebBundle::form.html.twig" ]

Features
--------

A full-features basic template
::::::::::::::::::::::::::::::

**Styling**:

* Less PHP
* Twitter Bootstrap
* Font Awesome
* Famfamfam flags

**Javascript**:

* jQuery
* jQuery UI

**Integration with Symfony2**

* Form templating

  * Date picker
  * New form type (``form_section``, ``form_tabs``)

**To start using it, in your templates:**

.. code-block:: html+jinja

    {% extends "AlexWebBundle::base.html.twig" %}

    {% block title 'A yuupi title' %}

    {% block content %}
        Page content
    {% endblock %}

Locale listener
:::::::::::::::

A listener can be registered in the application (``LocaleListener``) to constraint
the request locale:

.. code-block:: yaml

    # Request will be constrainted to use one of those locale.
    # The chosen locale will be persisted in session
    alex_web:
        locale_listener: [ fr_FR, en_US, pt_PT ]

    # Disable listener
    alex_web:
        locale_listener: false

    # Constraint on one locale
    alex_web:
        locale_listener: fr_FR

    # Advances configuration
    alex_web:
        locale_listener:
            enabled: true
            locales: [fr_FR, en_US]
            session_key: null # disable persistence in session

Pagination template
:::::::::::::::::::

If you are using my `pagination library <http://github.com/alexandresalome/pagination>`_,
you might appreciate the template ``AlexWebBundle::pagination.html.twig``. To use it:

.. code-block:: html+jinja

    {% embed "AlexWebBundle::pagination.html.twig" %}
        {% block colspan '3' %}
        {% block head %}
            <th>Username</th>
            <th>Fullname</th>
            <th>Actions</th>
        {% endblock %}
        {% block body %}
            {% for user in pager %}
                <tr>
                    {# ... #}
                </tr>
            {% else %}
                <tr><td colspan="{{ block('colspan') }}"><em>no user</em></td></tr>
            {% endfor %}
        {% endblock %}
    {% endembed %}

Form extra widgets
::::::::::::::::::

**Form sections**

Structure your form with sections, a virtual form:

    $builder
        ->add($builder->create('informations' 'form_section')
            ->add('firstname', 'text')
            ->add('lastname', 'text')
        )
        ->add($builder->create('contacts', 'form_section')
            ->add('main', 'contact')
        )

**Form tabs**

Here is an example of a form with tabs:

.. code-block:: php

    $builder = $this->get('form.factory')->createBuilder('form_tabs');

    $builder
        ->add($builder->create('informations', 'form_tab')
            ->add('firstname', 'text')
            ->add('lastname', 'text')
        )
        ->add($builder->create('contacts', 'form_tab')
            ->add('main', 'contact')
        )
    ;


Additional dependencies
:::::::::::::::::::::::

In your ``composer.json``:

.. code-block:: json

    "require": {
        "leafo/lessphp": "~0.3",
        "twitter/bootstrap": "~2.3",
        "fortawesome/font-awesome": "~3.2"

        "jquery/jquery": "~1.10",
        "jquery/jquery-ui": "~1.10",
        "famfamfam/flags": "dev-master"
    },

    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "jquery/jquery",
                "version": "1.10.2",
                "dist": {
                    "url": "http://code.jquery.com/jquery-1.10.2.min.js",
                    "type": "file"
                }
            }
        },
        {
            "type": "package",
            "package": {
                "name": "jquery/jquery-ui",
                "version": "1.10.3",
                "dist": {
                    "url": "http://jqueryui.com/resources/download/jquery-ui-1.10.3.zip",
                    "type": "zip"
                }
            }
        },
        {
            "type": "package",
            "package": {
                "name": "famfamfam/flags",
                "version": "dev-master",
                "source": {
                    "url": "https://github.com/tkrotoff/famfamfam_flags.git",
                    "type": "git",
                    "reference": "master"
                }
            }
        }
    ]
