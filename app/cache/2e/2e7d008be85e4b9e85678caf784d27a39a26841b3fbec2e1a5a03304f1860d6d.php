<?php

/* error_404.tpl */
class __TwigTemplate_5af2584460c01effcea786743d73862e605bfd011782bcc1afee180acee92a21 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
<head>
\t<title>Surface - Default Error Page.</title>
  <style>
    body {
      padding: 0;
      margin: 0;
      background-color: #eee;
    }
    h2 {
      color: #000;
    }
  </style>
</head>
<body>
  <h2 style=\"text-align: center; padding: 15%;\">404 Page Not Found. <br/><small>Powered by Surface Framework.
  </small></h2>
</body>
</html>
";
    }

    public function getTemplateName()
    {
        return "error_404.tpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html>
<head>
\t<title>Surface - Default Error Page.</title>
  <style>
    body {
      padding: 0;
      margin: 0;
      background-color: #eee;
    }
    h2 {
      color: #000;
    }
  </style>
</head>
<body>
  <h2 style=\"text-align: center; padding: 15%;\">404 Page Not Found. <br/><small>Powered by Surface Framework.
  </small></h2>
</body>
</html>
", "error_404.tpl", "C:\\xampp\\htdocs\\msm\\app\\views\\error_404.tpl");
    }
}
