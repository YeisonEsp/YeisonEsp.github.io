CREATE OR REPLACE FUNCTION fun_delete_tipoproducto( wid_tipoproducto	tipoproducto.tipoProId%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wtip tipoproducto.tipoProId%TYPE;
    DECLARE wmessage VARCHAR;
    DECLARE wtipopro tipoproducto.tipoProId%TYPE;
    BEGIN
        wmessage='00000';
        SELECT tipoProId INTO wtipopro FROM tipoproducto WHERE tipoProId=wid_tipoproducto FOR UPDATE;
        SELECT idTipoPro INTO wtip FROM producto WHERE idTipoPro=wid_tipoproducto;
        IF  NOT FOUND THEN
            DELETE FROM tipoproducto
            WHERE tipoProId = wid_tipoproducto;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage='Error en la eliminación';
                RETURN wmessage;
            END IF;
        ELSE
            wmessage='No se puede eliminar porque hay productos pertenecientes a esta categoría';
            RETURN wmessage;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;