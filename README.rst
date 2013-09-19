AlexWebBundle
=============

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

Base controller
---------------

``Controller`` from this bundle provides a bunch of useful methods.

Take a `look at the class <https://github.com/alexandresalome/web-bundle/blob/master/Controller/Controller.php>`_
for an exhaustive feature list.

Data Fixtures
-------------

A full-featured fixture class is available in this bundle:

* getReference/setReference
* Default order (1)
* Container injection

To start using it:

.. code-block:: php

    namespace Acme\DemoBundle\DataFixtures\ORM;

    use Alex\WebBundle\DataFixtures\ORMFixture;
    use Doctrine\Common\Persistence\ObjectManager;

    class UserData extends ORMFixture
    {
        public function load(ObjectManager $manager)
        {
            $this->get('security.encoder_factory');
            // ...
        }
    }


Form templating
---------------

Twitter Bootstrap 3.0 templating is available in this bundle for forms. In Twig
configuration, add form templating:

    twig:
        form:
            resources: [ "AlexWebBundle::form_bootstrap3_layout.html.twig" ]

Locale listener
---------------

A listener can be registered in the application (``LocaleListener``) to constraint
the request locale.

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
