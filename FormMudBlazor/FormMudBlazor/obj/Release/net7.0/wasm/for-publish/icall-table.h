#define ICALL_TABLE_corlib 1

static int corlib_icall_indexes [] = {
179,
185,
186,
187,
188,
189,
190,
191,
192,
195,
196,
291,
292,
294,
322,
323,
324,
344,
345,
346,
347,
445,
446,
447,
450,
485,
486,
488,
490,
492,
494,
499,
507,
508,
509,
510,
511,
512,
513,
514,
515,
650,
658,
661,
663,
668,
669,
671,
672,
676,
677,
679,
680,
683,
684,
685,
688,
690,
693,
695,
697,
766,
768,
770,
779,
780,
781,
783,
789,
790,
791,
792,
793,
801,
802,
803,
807,
808,
810,
812,
1006,
1181,
1182,
5968,
5969,
5971,
5972,
5973,
5974,
5975,
5977,
5979,
5981,
5982,
5991,
5993,
5999,
6000,
6002,
6004,
6006,
6017,
6026,
6027,
6029,
6030,
6031,
6032,
6033,
6035,
6037,
7036,
7040,
7042,
7043,
7044,
7045,
7177,
7178,
7179,
7180,
7200,
7201,
7202,
7204,
7244,
7295,
7297,
7308,
7309,
7310,
7688,
7692,
7693,
7722,
7743,
7749,
7756,
7766,
7770,
7847,
7849,
7861,
7863,
7864,
7865,
7872,
7885,
7905,
7906,
7914,
7916,
7923,
7924,
7927,
7929,
7934,
7940,
7941,
7948,
7950,
7962,
7965,
7966,
7967,
7978,
7987,
7993,
7994,
7995,
7997,
7998,
8016,
8018,
8032,
8054,
8055,
8075,
8105,
8106,
8536,
8676,
8911,
8912,
8919,
8920,
8921,
8926,
8986,
9293,
9294,
10215,
10236,
10243,
10245,
};
void ves_icall_System_Array_InternalCreate (int,int,int,int,int);
int ves_icall_System_Array_GetCorElementTypeOfElementType_raw (int,int);
int ves_icall_System_Array_CanChangePrimitive (int,int,int);
int ves_icall_System_Array_FastCopy_raw (int,int,int,int,int,int);
int ves_icall_System_Array_GetLength_raw (int,int,int);
int ves_icall_System_Array_GetLowerBound_raw (int,int,int);
void ves_icall_System_Array_GetGenericValue_icall (int,int,int);
int ves_icall_System_Array_GetValueImpl_raw (int,int,int);
void ves_icall_System_Array_SetGenericValue_icall (int,int,int);
void ves_icall_System_Array_SetValueImpl_raw (int,int,int,int);
void ves_icall_System_Array_SetValueRelaxedImpl_raw (int,int,int,int);
void ves_icall_System_Runtime_RuntimeImports_Memmove (int,int,int);
void ves_icall_System_Buffer_BulkMoveWithWriteBarrier (int,int,int,int);
void ves_icall_System_Runtime_RuntimeImports_ZeroMemory (int,int);
int ves_icall_System_Delegate_AllocDelegateLike_internal_raw (int,int);
int ves_icall_System_Delegate_CreateDelegate_internal_raw (int,int,int,int,int);
int ves_icall_System_Delegate_GetVirtualMethod_internal_raw (int,int);
int ves_icall_System_Enum_GetEnumValuesAndNames_raw (int,int,int,int);
void ves_icall_System_Enum_InternalBoxEnum_raw (int,int,int64_t,int);
int ves_icall_System_Enum_InternalGetCorElementType (int);
void ves_icall_System_Enum_InternalGetUnderlyingType_raw (int,int,int);
int ves_icall_System_Environment_get_ProcessorCount ();
int ves_icall_System_Environment_get_TickCount ();
int64_t ves_icall_System_Environment_get_TickCount64 ();
void ves_icall_System_Environment_FailFast_raw (int,int,int,int);
void ves_icall_System_GC_register_ephemeron_array_raw (int,int);
int ves_icall_System_GC_get_ephemeron_tombstone_raw (int);
void ves_icall_System_GC_SuppressFinalize_raw (int,int);
void ves_icall_System_GC_ReRegisterForFinalize_raw (int,int);
void ves_icall_System_GC_GetGCMemoryInfo (int,int,int,int,int,int);
int ves_icall_System_GC_AllocPinnedArray_raw (int,int,int);
int ves_icall_System_Object_MemberwiseClone_raw (int,int);
double ves_icall_System_Math_Ceiling (double);
double ves_icall_System_Math_Cos (double);
double ves_icall_System_Math_Floor (double);
double ves_icall_System_Math_Log10 (double);
double ves_icall_System_Math_Pow (double,double);
double ves_icall_System_Math_Sin (double);
double ves_icall_System_Math_Sqrt (double);
double ves_icall_System_Math_Tan (double);
double ves_icall_System_Math_ModF (double,int);
int ves_icall_RuntimeType_GetCorrespondingInflatedMethod_raw (int,int,int);
void ves_icall_RuntimeType_make_array_type_raw (int,int,int,int);
void ves_icall_RuntimeType_make_byref_type_raw (int,int,int);
void ves_icall_RuntimeType_make_pointer_type_raw (int,int,int);
void ves_icall_RuntimeType_MakeGenericType_raw (int,int,int,int);
int ves_icall_RuntimeType_GetMethodsByName_native_raw (int,int,int,int,int);
int ves_icall_RuntimeType_GetPropertiesByName_native_raw (int,int,int,int,int);
int ves_icall_RuntimeType_GetConstructors_native_raw (int,int,int);
int ves_icall_System_RuntimeType_CreateInstanceInternal_raw (int,int);
void ves_icall_RuntimeType_GetDeclaringMethod_raw (int,int,int);
void ves_icall_System_RuntimeType_getFullName_raw (int,int,int,int,int);
void ves_icall_RuntimeType_GetGenericArgumentsInternal_raw (int,int,int,int);
int ves_icall_RuntimeType_GetGenericParameterPosition (int);
int ves_icall_RuntimeType_GetEvents_native_raw (int,int,int,int);
int ves_icall_RuntimeType_GetFields_native_raw (int,int,int,int,int);
void ves_icall_RuntimeType_GetInterfaces_raw (int,int,int);
int ves_icall_RuntimeType_GetNestedTypes_native_raw (int,int,int,int,int);
void ves_icall_RuntimeType_GetDeclaringType_raw (int,int,int);
void ves_icall_RuntimeType_GetName_raw (int,int,int);
void ves_icall_RuntimeType_GetNamespace_raw (int,int,int);
int ves_icall_RuntimeTypeHandle_GetAttributes (int);
int ves_icall_RuntimeTypeHandle_GetMetadataToken_raw (int,int);
void ves_icall_RuntimeTypeHandle_GetGenericTypeDefinition_impl_raw (int,int,int);
int ves_icall_RuntimeTypeHandle_GetCorElementType (int);
int ves_icall_RuntimeTypeHandle_HasInstantiation (int);
int ves_icall_RuntimeTypeHandle_IsInstanceOfType_raw (int,int,int);
int ves_icall_RuntimeTypeHandle_HasReferences_raw (int,int);
int ves_icall_RuntimeTypeHandle_GetArrayRank_raw (int,int);
void ves_icall_RuntimeTypeHandle_GetAssembly_raw (int,int,int);
void ves_icall_RuntimeTypeHandle_GetElementType_raw (int,int,int);
void ves_icall_RuntimeTypeHandle_GetModule_raw (int,int,int);
void ves_icall_RuntimeTypeHandle_GetBaseType_raw (int,int,int);
int ves_icall_RuntimeTypeHandle_type_is_assignable_from_raw (int,int,int);
int ves_icall_RuntimeTypeHandle_IsGenericTypeDefinition (int);
int ves_icall_RuntimeTypeHandle_GetGenericParameterInfo_raw (int,int);
int ves_icall_RuntimeTypeHandle_is_subclass_of_raw (int,int,int);
int ves_icall_RuntimeTypeHandle_IsByRefLike_raw (int,int);
void ves_icall_System_RuntimeTypeHandle_internal_from_name_raw (int,int,int,int,int,int);
int ves_icall_System_String_FastAllocateString_raw (int,int);
int ves_icall_System_Type_internal_from_handle_raw (int,int);
int ves_icall_System_ValueType_InternalGetHashCode_raw (int,int,int);
int ves_icall_System_ValueType_Equals_raw (int,int,int,int);
int ves_icall_System_Threading_Interlocked_CompareExchange_Int (int,int,int);
void ves_icall_System_Threading_Interlocked_CompareExchange_Object (int,int,int,int);
int ves_icall_System_Threading_Interlocked_Decrement_Int (int);
int ves_icall_System_Threading_Interlocked_Increment_Int (int);
int64_t ves_icall_System_Threading_Interlocked_Increment_Long (int);
int ves_icall_System_Threading_Interlocked_Exchange_Int (int,int);
void ves_icall_System_Threading_Interlocked_Exchange_Object (int,int,int);
int64_t ves_icall_System_Threading_Interlocked_CompareExchange_Long (int,int64_t,int64_t);
int64_t ves_icall_System_Threading_Interlocked_Exchange_Long (int,int64_t);
int64_t ves_icall_System_Threading_Interlocked_Read_Long (int);
int ves_icall_System_Threading_Interlocked_Add_Int (int,int);
void ves_icall_System_Threading_Monitor_Monitor_Enter_raw (int,int);
void mono_monitor_exit_icall_raw (int,int);
int ves_icall_System_Threading_Monitor_Monitor_test_synchronised_raw (int,int);
void ves_icall_System_Threading_Monitor_Monitor_pulse_raw (int,int);
void ves_icall_System_Threading_Monitor_Monitor_pulse_all_raw (int,int);
int ves_icall_System_Threading_Monitor_Monitor_wait_raw (int,int,int,int);
void ves_icall_System_Threading_Monitor_Monitor_try_enter_with_atomic_var_raw (int,int,int,int,int);
int ves_icall_System_Threading_Thread_GetCurrentProcessorNumber_raw (int);
void ves_icall_System_Threading_Thread_InitInternal_raw (int,int);
int ves_icall_System_Threading_Thread_GetCurrentThread ();
void ves_icall_System_Threading_InternalThread_Thread_free_internal_raw (int,int);
int ves_icall_System_Threading_Thread_GetState_raw (int,int);
void ves_icall_System_Threading_Thread_SetState_raw (int,int,int);
void ves_icall_System_Threading_Thread_ClrState_raw (int,int,int);
void ves_icall_System_Threading_Thread_SetName_icall_raw (int,int,int,int);
int ves_icall_System_Threading_Thread_YieldInternal ();
void ves_icall_System_Threading_Thread_SetPriority_raw (int,int,int);
void ves_icall_System_Runtime_Loader_AssemblyLoadContext_PrepareForAssemblyLoadContextRelease_raw (int,int,int);
int ves_icall_System_Runtime_Loader_AssemblyLoadContext_GetLoadContextForAssembly_raw (int,int);
int ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalLoadFile_raw (int,int,int,int);
int ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalInitializeNativeALC_raw (int,int,int,int,int);
int ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalLoadFromStream_raw (int,int,int,int,int,int);
int ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalGetLoadedAssemblies_raw (int);
int ves_icall_System_GCHandle_InternalAlloc_raw (int,int,int);
void ves_icall_System_GCHandle_InternalFree_raw (int,int);
int ves_icall_System_GCHandle_InternalGet_raw (int,int);
void ves_icall_System_GCHandle_InternalSet_raw (int,int,int);
int ves_icall_System_Runtime_InteropServices_Marshal_GetLastPInvokeError ();
void ves_icall_System_Runtime_InteropServices_Marshal_SetLastPInvokeError (int);
void ves_icall_System_Runtime_InteropServices_Marshal_StructureToPtr_raw (int,int,int,int);
int ves_icall_System_Runtime_InteropServices_Marshal_SizeOfHelper_raw (int,int,int);
int ves_icall_System_Runtime_InteropServices_NativeLibrary_LoadByName_raw (int,int,int,int,int,int);
int mono_object_hash_icall_raw (int,int);
int ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_GetObjectValue_raw (int,int);
int ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_GetUninitializedObjectInternal_raw (int,int);
void ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_InitializeArray_raw (int,int,int);
int ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_SufficientExecutionStack ();
int ves_icall_System_Reflection_Assembly_GetEntryAssembly_raw (int);
int ves_icall_System_Reflection_Assembly_InternalLoad_raw (int,int,int,int);
int ves_icall_System_Reflection_Assembly_InternalGetType_raw (int,int,int,int,int,int);
int ves_icall_System_Reflection_AssemblyName_GetNativeName (int);
int ves_icall_MonoCustomAttrs_GetCustomAttributesInternal_raw (int,int,int,int);
int ves_icall_MonoCustomAttrs_GetCustomAttributesDataInternal_raw (int,int);
int ves_icall_MonoCustomAttrs_IsDefinedInternal_raw (int,int,int);
int ves_icall_System_Reflection_FieldInfo_internal_from_handle_type_raw (int,int,int);
int ves_icall_System_Reflection_FieldInfo_get_marshal_info_raw (int,int);
void ves_icall_System_Reflection_RuntimeAssembly_GetManifestResourceNames_raw (int,int,int);
void ves_icall_System_Reflection_RuntimeAssembly_GetExportedTypes_raw (int,int,int);
void ves_icall_System_Reflection_RuntimeAssembly_GetInfo_raw (int,int,int,int);
int ves_icall_System_Reflection_RuntimeAssembly_GetManifestResourceInternal_raw (int,int,int,int,int);
void ves_icall_System_Reflection_Assembly_GetManifestModuleInternal_raw (int,int,int);
void ves_icall_System_Reflection_RuntimeAssembly_GetModulesInternal_raw (int,int,int);
void ves_icall_System_Reflection_RuntimeCustomAttributeData_ResolveArgumentsInternal_raw (int,int,int,int,int,int,int);
void ves_icall_RuntimeEventInfo_get_event_info_raw (int,int,int);
int ves_icall_reflection_get_token_raw (int,int);
int ves_icall_System_Reflection_EventInfo_internal_from_handle_type_raw (int,int,int);
int ves_icall_RuntimeFieldInfo_ResolveType_raw (int,int);
int ves_icall_RuntimeFieldInfo_GetParentType_raw (int,int,int);
int ves_icall_RuntimeFieldInfo_GetFieldOffset_raw (int,int);
int ves_icall_RuntimeFieldInfo_GetValueInternal_raw (int,int,int);
void ves_icall_RuntimeFieldInfo_SetValueInternal_raw (int,int,int,int);
int ves_icall_RuntimeFieldInfo_GetRawConstantValue_raw (int,int);
int ves_icall_reflection_get_token_raw (int,int);
void ves_icall_get_method_info_raw (int,int,int);
int ves_icall_get_method_attributes (int);
int ves_icall_System_Reflection_MonoMethodInfo_get_parameter_info_raw (int,int,int);
int ves_icall_System_MonoMethodInfo_get_retval_marshal_raw (int,int);
int ves_icall_System_Reflection_RuntimeMethodInfo_GetMethodFromHandleInternalType_native_raw (int,int,int,int);
int ves_icall_RuntimeMethodInfo_get_name_raw (int,int);
int ves_icall_RuntimeMethodInfo_get_base_method_raw (int,int,int);
int ves_icall_reflection_get_token_raw (int,int);
int ves_icall_InternalInvoke_raw (int,int,int,int,int);
void ves_icall_RuntimeMethodInfo_GetPInvoke_raw (int,int,int,int,int);
int ves_icall_RuntimeMethodInfo_MakeGenericMethod_impl_raw (int,int,int);
int ves_icall_RuntimeMethodInfo_GetGenericArguments_raw (int,int);
int ves_icall_RuntimeMethodInfo_GetGenericMethodDefinition_raw (int,int);
int ves_icall_RuntimeMethodInfo_get_IsGenericMethodDefinition_raw (int,int);
int ves_icall_RuntimeMethodInfo_get_IsGenericMethod_raw (int,int);
void ves_icall_InvokeClassConstructor_raw (int,int);
int ves_icall_InternalInvoke_raw (int,int,int,int,int);
int ves_icall_reflection_get_token_raw (int,int);
int ves_icall_System_Reflection_RuntimeModule_InternalGetTypes_raw (int,int);
int ves_icall_System_Reflection_RuntimeModule_ResolveMethodToken_raw (int,int,int,int,int,int);
void ves_icall_RuntimePropertyInfo_get_property_info_raw (int,int,int,int);
int ves_icall_reflection_get_token_raw (int,int);
int ves_icall_System_Reflection_RuntimePropertyInfo_internal_from_handle_type_raw (int,int,int);
void ves_icall_AssemblyBuilder_basic_init_raw (int,int);
void ves_icall_DynamicMethod_create_dynamic_method_raw (int,int);
void ves_icall_ModuleBuilder_basic_init_raw (int,int);
void ves_icall_ModuleBuilder_set_wrappers_type_raw (int,int,int);
int ves_icall_ModuleBuilder_getUSIndex_raw (int,int,int);
int ves_icall_ModuleBuilder_getToken_raw (int,int,int,int);
int ves_icall_ModuleBuilder_getMethodToken_raw (int,int,int,int);
void ves_icall_ModuleBuilder_RegisterToken_raw (int,int,int,int);
int ves_icall_TypeBuilder_create_runtime_class_raw (int,int);
int ves_icall_System_IO_Stream_HasOverriddenBeginEndRead_raw (int,int);
int ves_icall_System_IO_Stream_HasOverriddenBeginEndWrite_raw (int,int);
int ves_icall_Mono_RuntimeClassHandle_GetTypeFromClass (int);
void ves_icall_Mono_RuntimeGPtrArrayHandle_GPtrArrayFree (int);
int ves_icall_Mono_SafeStringMarshal_StringToUtf8 (int);
void ves_icall_Mono_SafeStringMarshal_GFree (int);
static void *corlib_icall_funcs [] = {
// token 179,
ves_icall_System_Array_InternalCreate,
// token 185,
ves_icall_System_Array_GetCorElementTypeOfElementType_raw,
// token 186,
ves_icall_System_Array_CanChangePrimitive,
// token 187,
ves_icall_System_Array_FastCopy_raw,
// token 188,
ves_icall_System_Array_GetLength_raw,
// token 189,
ves_icall_System_Array_GetLowerBound_raw,
// token 190,
ves_icall_System_Array_GetGenericValue_icall,
// token 191,
ves_icall_System_Array_GetValueImpl_raw,
// token 192,
ves_icall_System_Array_SetGenericValue_icall,
// token 195,
ves_icall_System_Array_SetValueImpl_raw,
// token 196,
ves_icall_System_Array_SetValueRelaxedImpl_raw,
// token 291,
ves_icall_System_Runtime_RuntimeImports_Memmove,
// token 292,
ves_icall_System_Buffer_BulkMoveWithWriteBarrier,
// token 294,
ves_icall_System_Runtime_RuntimeImports_ZeroMemory,
// token 322,
ves_icall_System_Delegate_AllocDelegateLike_internal_raw,
// token 323,
ves_icall_System_Delegate_CreateDelegate_internal_raw,
// token 324,
ves_icall_System_Delegate_GetVirtualMethod_internal_raw,
// token 344,
ves_icall_System_Enum_GetEnumValuesAndNames_raw,
// token 345,
ves_icall_System_Enum_InternalBoxEnum_raw,
// token 346,
ves_icall_System_Enum_InternalGetCorElementType,
// token 347,
ves_icall_System_Enum_InternalGetUnderlyingType_raw,
// token 445,
ves_icall_System_Environment_get_ProcessorCount,
// token 446,
ves_icall_System_Environment_get_TickCount,
// token 447,
ves_icall_System_Environment_get_TickCount64,
// token 450,
ves_icall_System_Environment_FailFast_raw,
// token 485,
ves_icall_System_GC_register_ephemeron_array_raw,
// token 486,
ves_icall_System_GC_get_ephemeron_tombstone_raw,
// token 488,
ves_icall_System_GC_SuppressFinalize_raw,
// token 490,
ves_icall_System_GC_ReRegisterForFinalize_raw,
// token 492,
ves_icall_System_GC_GetGCMemoryInfo,
// token 494,
ves_icall_System_GC_AllocPinnedArray_raw,
// token 499,
ves_icall_System_Object_MemberwiseClone_raw,
// token 507,
ves_icall_System_Math_Ceiling,
// token 508,
ves_icall_System_Math_Cos,
// token 509,
ves_icall_System_Math_Floor,
// token 510,
ves_icall_System_Math_Log10,
// token 511,
ves_icall_System_Math_Pow,
// token 512,
ves_icall_System_Math_Sin,
// token 513,
ves_icall_System_Math_Sqrt,
// token 514,
ves_icall_System_Math_Tan,
// token 515,
ves_icall_System_Math_ModF,
// token 650,
ves_icall_RuntimeType_GetCorrespondingInflatedMethod_raw,
// token 658,
ves_icall_RuntimeType_make_array_type_raw,
// token 661,
ves_icall_RuntimeType_make_byref_type_raw,
// token 663,
ves_icall_RuntimeType_make_pointer_type_raw,
// token 668,
ves_icall_RuntimeType_MakeGenericType_raw,
// token 669,
ves_icall_RuntimeType_GetMethodsByName_native_raw,
// token 671,
ves_icall_RuntimeType_GetPropertiesByName_native_raw,
// token 672,
ves_icall_RuntimeType_GetConstructors_native_raw,
// token 676,
ves_icall_System_RuntimeType_CreateInstanceInternal_raw,
// token 677,
ves_icall_RuntimeType_GetDeclaringMethod_raw,
// token 679,
ves_icall_System_RuntimeType_getFullName_raw,
// token 680,
ves_icall_RuntimeType_GetGenericArgumentsInternal_raw,
// token 683,
ves_icall_RuntimeType_GetGenericParameterPosition,
// token 684,
ves_icall_RuntimeType_GetEvents_native_raw,
// token 685,
ves_icall_RuntimeType_GetFields_native_raw,
// token 688,
ves_icall_RuntimeType_GetInterfaces_raw,
// token 690,
ves_icall_RuntimeType_GetNestedTypes_native_raw,
// token 693,
ves_icall_RuntimeType_GetDeclaringType_raw,
// token 695,
ves_icall_RuntimeType_GetName_raw,
// token 697,
ves_icall_RuntimeType_GetNamespace_raw,
// token 766,
ves_icall_RuntimeTypeHandle_GetAttributes,
// token 768,
ves_icall_RuntimeTypeHandle_GetMetadataToken_raw,
// token 770,
ves_icall_RuntimeTypeHandle_GetGenericTypeDefinition_impl_raw,
// token 779,
ves_icall_RuntimeTypeHandle_GetCorElementType,
// token 780,
ves_icall_RuntimeTypeHandle_HasInstantiation,
// token 781,
ves_icall_RuntimeTypeHandle_IsInstanceOfType_raw,
// token 783,
ves_icall_RuntimeTypeHandle_HasReferences_raw,
// token 789,
ves_icall_RuntimeTypeHandle_GetArrayRank_raw,
// token 790,
ves_icall_RuntimeTypeHandle_GetAssembly_raw,
// token 791,
ves_icall_RuntimeTypeHandle_GetElementType_raw,
// token 792,
ves_icall_RuntimeTypeHandle_GetModule_raw,
// token 793,
ves_icall_RuntimeTypeHandle_GetBaseType_raw,
// token 801,
ves_icall_RuntimeTypeHandle_type_is_assignable_from_raw,
// token 802,
ves_icall_RuntimeTypeHandle_IsGenericTypeDefinition,
// token 803,
ves_icall_RuntimeTypeHandle_GetGenericParameterInfo_raw,
// token 807,
ves_icall_RuntimeTypeHandle_is_subclass_of_raw,
// token 808,
ves_icall_RuntimeTypeHandle_IsByRefLike_raw,
// token 810,
ves_icall_System_RuntimeTypeHandle_internal_from_name_raw,
// token 812,
ves_icall_System_String_FastAllocateString_raw,
// token 1006,
ves_icall_System_Type_internal_from_handle_raw,
// token 1181,
ves_icall_System_ValueType_InternalGetHashCode_raw,
// token 1182,
ves_icall_System_ValueType_Equals_raw,
// token 5968,
ves_icall_System_Threading_Interlocked_CompareExchange_Int,
// token 5969,
ves_icall_System_Threading_Interlocked_CompareExchange_Object,
// token 5971,
ves_icall_System_Threading_Interlocked_Decrement_Int,
// token 5972,
ves_icall_System_Threading_Interlocked_Increment_Int,
// token 5973,
ves_icall_System_Threading_Interlocked_Increment_Long,
// token 5974,
ves_icall_System_Threading_Interlocked_Exchange_Int,
// token 5975,
ves_icall_System_Threading_Interlocked_Exchange_Object,
// token 5977,
ves_icall_System_Threading_Interlocked_CompareExchange_Long,
// token 5979,
ves_icall_System_Threading_Interlocked_Exchange_Long,
// token 5981,
ves_icall_System_Threading_Interlocked_Read_Long,
// token 5982,
ves_icall_System_Threading_Interlocked_Add_Int,
// token 5991,
ves_icall_System_Threading_Monitor_Monitor_Enter_raw,
// token 5993,
mono_monitor_exit_icall_raw,
// token 5999,
ves_icall_System_Threading_Monitor_Monitor_test_synchronised_raw,
// token 6000,
ves_icall_System_Threading_Monitor_Monitor_pulse_raw,
// token 6002,
ves_icall_System_Threading_Monitor_Monitor_pulse_all_raw,
// token 6004,
ves_icall_System_Threading_Monitor_Monitor_wait_raw,
// token 6006,
ves_icall_System_Threading_Monitor_Monitor_try_enter_with_atomic_var_raw,
// token 6017,
ves_icall_System_Threading_Thread_GetCurrentProcessorNumber_raw,
// token 6026,
ves_icall_System_Threading_Thread_InitInternal_raw,
// token 6027,
ves_icall_System_Threading_Thread_GetCurrentThread,
// token 6029,
ves_icall_System_Threading_InternalThread_Thread_free_internal_raw,
// token 6030,
ves_icall_System_Threading_Thread_GetState_raw,
// token 6031,
ves_icall_System_Threading_Thread_SetState_raw,
// token 6032,
ves_icall_System_Threading_Thread_ClrState_raw,
// token 6033,
ves_icall_System_Threading_Thread_SetName_icall_raw,
// token 6035,
ves_icall_System_Threading_Thread_YieldInternal,
// token 6037,
ves_icall_System_Threading_Thread_SetPriority_raw,
// token 7036,
ves_icall_System_Runtime_Loader_AssemblyLoadContext_PrepareForAssemblyLoadContextRelease_raw,
// token 7040,
ves_icall_System_Runtime_Loader_AssemblyLoadContext_GetLoadContextForAssembly_raw,
// token 7042,
ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalLoadFile_raw,
// token 7043,
ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalInitializeNativeALC_raw,
// token 7044,
ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalLoadFromStream_raw,
// token 7045,
ves_icall_System_Runtime_Loader_AssemblyLoadContext_InternalGetLoadedAssemblies_raw,
// token 7177,
ves_icall_System_GCHandle_InternalAlloc_raw,
// token 7178,
ves_icall_System_GCHandle_InternalFree_raw,
// token 7179,
ves_icall_System_GCHandle_InternalGet_raw,
// token 7180,
ves_icall_System_GCHandle_InternalSet_raw,
// token 7200,
ves_icall_System_Runtime_InteropServices_Marshal_GetLastPInvokeError,
// token 7201,
ves_icall_System_Runtime_InteropServices_Marshal_SetLastPInvokeError,
// token 7202,
ves_icall_System_Runtime_InteropServices_Marshal_StructureToPtr_raw,
// token 7204,
ves_icall_System_Runtime_InteropServices_Marshal_SizeOfHelper_raw,
// token 7244,
ves_icall_System_Runtime_InteropServices_NativeLibrary_LoadByName_raw,
// token 7295,
mono_object_hash_icall_raw,
// token 7297,
ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_GetObjectValue_raw,
// token 7308,
ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_GetUninitializedObjectInternal_raw,
// token 7309,
ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_InitializeArray_raw,
// token 7310,
ves_icall_System_Runtime_CompilerServices_RuntimeHelpers_SufficientExecutionStack,
// token 7688,
ves_icall_System_Reflection_Assembly_GetEntryAssembly_raw,
// token 7692,
ves_icall_System_Reflection_Assembly_InternalLoad_raw,
// token 7693,
ves_icall_System_Reflection_Assembly_InternalGetType_raw,
// token 7722,
ves_icall_System_Reflection_AssemblyName_GetNativeName,
// token 7743,
ves_icall_MonoCustomAttrs_GetCustomAttributesInternal_raw,
// token 7749,
ves_icall_MonoCustomAttrs_GetCustomAttributesDataInternal_raw,
// token 7756,
ves_icall_MonoCustomAttrs_IsDefinedInternal_raw,
// token 7766,
ves_icall_System_Reflection_FieldInfo_internal_from_handle_type_raw,
// token 7770,
ves_icall_System_Reflection_FieldInfo_get_marshal_info_raw,
// token 7847,
ves_icall_System_Reflection_RuntimeAssembly_GetManifestResourceNames_raw,
// token 7849,
ves_icall_System_Reflection_RuntimeAssembly_GetExportedTypes_raw,
// token 7861,
ves_icall_System_Reflection_RuntimeAssembly_GetInfo_raw,
// token 7863,
ves_icall_System_Reflection_RuntimeAssembly_GetManifestResourceInternal_raw,
// token 7864,
ves_icall_System_Reflection_Assembly_GetManifestModuleInternal_raw,
// token 7865,
ves_icall_System_Reflection_RuntimeAssembly_GetModulesInternal_raw,
// token 7872,
ves_icall_System_Reflection_RuntimeCustomAttributeData_ResolveArgumentsInternal_raw,
// token 7885,
ves_icall_RuntimeEventInfo_get_event_info_raw,
// token 7905,
ves_icall_reflection_get_token_raw,
// token 7906,
ves_icall_System_Reflection_EventInfo_internal_from_handle_type_raw,
// token 7914,
ves_icall_RuntimeFieldInfo_ResolveType_raw,
// token 7916,
ves_icall_RuntimeFieldInfo_GetParentType_raw,
// token 7923,
ves_icall_RuntimeFieldInfo_GetFieldOffset_raw,
// token 7924,
ves_icall_RuntimeFieldInfo_GetValueInternal_raw,
// token 7927,
ves_icall_RuntimeFieldInfo_SetValueInternal_raw,
// token 7929,
ves_icall_RuntimeFieldInfo_GetRawConstantValue_raw,
// token 7934,
ves_icall_reflection_get_token_raw,
// token 7940,
ves_icall_get_method_info_raw,
// token 7941,
ves_icall_get_method_attributes,
// token 7948,
ves_icall_System_Reflection_MonoMethodInfo_get_parameter_info_raw,
// token 7950,
ves_icall_System_MonoMethodInfo_get_retval_marshal_raw,
// token 7962,
ves_icall_System_Reflection_RuntimeMethodInfo_GetMethodFromHandleInternalType_native_raw,
// token 7965,
ves_icall_RuntimeMethodInfo_get_name_raw,
// token 7966,
ves_icall_RuntimeMethodInfo_get_base_method_raw,
// token 7967,
ves_icall_reflection_get_token_raw,
// token 7978,
ves_icall_InternalInvoke_raw,
// token 7987,
ves_icall_RuntimeMethodInfo_GetPInvoke_raw,
// token 7993,
ves_icall_RuntimeMethodInfo_MakeGenericMethod_impl_raw,
// token 7994,
ves_icall_RuntimeMethodInfo_GetGenericArguments_raw,
// token 7995,
ves_icall_RuntimeMethodInfo_GetGenericMethodDefinition_raw,
// token 7997,
ves_icall_RuntimeMethodInfo_get_IsGenericMethodDefinition_raw,
// token 7998,
ves_icall_RuntimeMethodInfo_get_IsGenericMethod_raw,
// token 8016,
ves_icall_InvokeClassConstructor_raw,
// token 8018,
ves_icall_InternalInvoke_raw,
// token 8032,
ves_icall_reflection_get_token_raw,
// token 8054,
ves_icall_System_Reflection_RuntimeModule_InternalGetTypes_raw,
// token 8055,
ves_icall_System_Reflection_RuntimeModule_ResolveMethodToken_raw,
// token 8075,
ves_icall_RuntimePropertyInfo_get_property_info_raw,
// token 8105,
ves_icall_reflection_get_token_raw,
// token 8106,
ves_icall_System_Reflection_RuntimePropertyInfo_internal_from_handle_type_raw,
// token 8536,
ves_icall_AssemblyBuilder_basic_init_raw,
// token 8676,
ves_icall_DynamicMethod_create_dynamic_method_raw,
// token 8911,
ves_icall_ModuleBuilder_basic_init_raw,
// token 8912,
ves_icall_ModuleBuilder_set_wrappers_type_raw,
// token 8919,
ves_icall_ModuleBuilder_getUSIndex_raw,
// token 8920,
ves_icall_ModuleBuilder_getToken_raw,
// token 8921,
ves_icall_ModuleBuilder_getMethodToken_raw,
// token 8926,
ves_icall_ModuleBuilder_RegisterToken_raw,
// token 8986,
ves_icall_TypeBuilder_create_runtime_class_raw,
// token 9293,
ves_icall_System_IO_Stream_HasOverriddenBeginEndRead_raw,
// token 9294,
ves_icall_System_IO_Stream_HasOverriddenBeginEndWrite_raw,
// token 10215,
ves_icall_Mono_RuntimeClassHandle_GetTypeFromClass,
// token 10236,
ves_icall_Mono_RuntimeGPtrArrayHandle_GPtrArrayFree,
// token 10243,
ves_icall_Mono_SafeStringMarshal_StringToUtf8,
// token 10245,
ves_icall_Mono_SafeStringMarshal_GFree,
};
static uint8_t corlib_icall_handles [] = {
0,
1,
0,
1,
1,
1,
0,
1,
0,
1,
1,
0,
0,
0,
1,
1,
1,
1,
1,
0,
1,
0,
0,
0,
1,
1,
1,
1,
1,
0,
1,
1,
0,
0,
0,
0,
0,
0,
0,
0,
0,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
0,
1,
1,
1,
1,
1,
1,
1,
0,
1,
1,
0,
0,
1,
1,
1,
1,
1,
1,
1,
1,
0,
1,
1,
1,
1,
1,
1,
1,
1,
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
0,
1,
1,
1,
1,
1,
1,
1,
1,
1,
0,
1,
1,
1,
1,
1,
0,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
0,
0,
1,
1,
1,
1,
1,
1,
1,
0,
1,
1,
1,
0,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
0,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
1,
0,
0,
0,
0,
};
