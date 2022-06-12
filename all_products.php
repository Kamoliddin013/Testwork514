<?php
/*
Template Name: All products
*/
echo do_shortcode('[products limit="8" columns="4" orderby="id" order="DESC" visibility="visible"]');
?>
<style>
    ul.products.columns-4 {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    li {
        list-style: none;
        width: 25%;
        margin-bottom: 30px;
    }
</style>
