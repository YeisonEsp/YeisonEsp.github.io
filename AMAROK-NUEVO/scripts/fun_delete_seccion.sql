CREATE OR REPLACE FUNCTION fun_delete_seccion(wnom_estante        seccion.nomEstant%TYPE, 
                                                wnum_bandeja       seccion.numBandeja%TYPE,
                                                wcod_seccion       seccion.seccionCod%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wseccion seccion.seccionCod%TYPE;
    BEGIN
        wmessage='00000';
        SELECT seccionCod INTO wseccion FROM seccion WHERE  nomEstant = wnom_estante AND numBandeja = wnum_bandeja AND seccionCod = wcod_seccion FOR UPDATE;
        DELETE FROM seccion
        WHERE  nomEstant = wnom_estante AND numBandeja = wnum_bandeja AND seccionCod = wcod_seccion;
        IF FOUND THEN
            RETURN wmessage;
        ELSE
            wmessage='Error al eliminar';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;