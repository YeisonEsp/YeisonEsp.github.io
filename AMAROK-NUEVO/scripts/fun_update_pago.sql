CREATE OR REPLACE FUNCTION fun_update_pago(wnum_pedido	pedidoproveedor.pedidoNum%TYPE,
                                            wnit_proveedor proveedor.proveeNit%TYPE,
                                            wpago_pedido pedidoproveedor.pedidoPag%TYPE,
                                            wtipo_pago pedidoproveedor.tipopago%TYPE,
                                            wuser_update pedidoproveedor.usr_update%TYPE,
                                            wuser_update_rol  pedidoproveedor.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wpedido 	pedidoproveedor.pedidoNum%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT pedidoNum INTO wpedido from pedidoproveedor 
		WHERE pedidoNum= wnum_pedido AND nitProvee = wnit_proveedor FOR UPDATE;
		IF NOT FOUND THEN
			wmessage = 'El pedido no se encuentra registrado';
			RETURN wmessage;
		END IF;
        
        IF (wtipo_pago = 'Ninguno' AND wpago_pedido = TRUE) OR (wtipo_pago != 'Ninguno' AND wpago_pedido = FALSE) THEN
            wmessage = 'Si se realizó el pago, el modo de pagarlo no puede ser (Ninguno), y viceversa tampoco.';
            RETURN wmessage;
        END IF;
        UPDATE pedidoproveedor SET pedidoPag = wpago_pedido,
                                    tipopago = wtipo_pago,
                                    usr_update       = wuser_update,
                                    usr_update_rol   = wuser_update_rol,
                                    fec_update       = now()
        WHERE pedidoNum = wnum_pedido AND nitProvee = wnit_proveedor;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage = 'Error en la actualización';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;