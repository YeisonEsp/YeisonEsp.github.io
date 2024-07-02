CREATE OR REPLACE FUNCTION fun_delete_empresa(wnit_empresa empresatransporte.empreTraNit%TYPE,
                                                wuser_update empresatransporte.usr_update%TYPE,
                                                wuser_update_rol  empresatransporte.usr_update_rol%TYPE) RETURNS VARCHAR AS
$BODY$
    DECLARE wmessage VARCHAR;
    DECLARE wempresa empresatransporte.empreTraNit%TYPE;
    DECLARE wenvio empresatransporte.empreTraNit%TYPE;
    BEGIN
        wmessage = '00000';
        SELECT empreTraNit INTO wempresa FROM empresatransporte WHERE empreTraNit=wnit_empresa FOR UPDATE;
        IF NOT FOUND THEN
            wmessage = 'La empresa de transporte no se encuentra registrada';
            RETURN wmessage;
        END IF;
        SELECT nitEmpreTra INTO wenvio FROM envio WHERE nitEmpreTra=wnit_empresa;
        IF NOT FOUND THEN
            DELETE FROM empresatransporte
            WHERE empreTraNit = wnit_empresa;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la eliminación';
                RETURN wmessage;
            END IF;
        ELSE
            UPDATE empresatransporte SET empreTraAct = FALSE,
                                usr_update      = wuser_update,
                                usr_update_rol  = wuser_update_rol,
                                fec_update      = now()
            WHERE empreTraNit = wnit_empresa;
            IF FOUND THEN
                RETURN wmessage;
            ELSE
                wmessage = 'Error en la desactivación';
                RETURN wmessage;
            END IF;
        END IF;
    END;
$BODY$
LANGUAGE PLPGSQL;