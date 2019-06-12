<?php
/**
 * @package Sprout
 * @subpackage Sprout/SproutIdentity
 * @since 1.0.0
 */
namespace Sprout\SproutIdentity;

final class ArrayIdentity
{
    /**
     * Computes an array (of objects) identity as an MD5 string.
     *
     * @internal The identity is not based on implementation details of each of these objects' methods.
     * @internal The identity, or rather, things json_encode takes into account is: values of public fields, the fields of a class, the methods, the method names, the class name, the interfaces it implements.
     *
     * @param array $array An array of objects.
     * @param boolean $strict A flag to signal whether or not the computation should perform additional checks.
     *
     * @return string|WP_Error Returns an MD5 string as the collective identity or a WP_Error if no array was provided.
     */
    public static function computeArrayIndetity( $array, $strict = False )
    {
        if( !is_array( $array ) ) {
            return new \WP_Error(
                'not-an-array',
                esc_html__( 'The provided item is not an array.', 'sprout' )
            );
        }

        if( $strict ) {
            foreach( $array as $array_item ) {
                if( !is_object( $array_item ) ) {
                    return new \WP_Error(
                        'contains-non-objects',
                        esc_html__( 'The provided array contains items that are not objects', 'sprout' ),
                        $array_item
                    );
                }
            }
        }

        $identity = '';

        foreach( $array as $array_item ) {
            $identity .= $array_item->getUniqueObjectIdentifier();
        }

        return md5( $identity );
    }
}