using FluentValidation;

namespace FormMudBlazor.Models
{
    public class RegistrationModelValidation:AbstractValidator<RegistrationModel>
    {
        public RegistrationModelValidation()
        {
            RuleFor(x => x.Name).NotEmpty().MinimumLength(3).MaximumLength(70)
                .Matches(@"^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+(?:\s+[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+){1,5}(?:\s+[-\sa-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+)?$")
                .WithMessage("El Name solo debe contener letras y puede tener máximo 70 caracteres."); ;
            RuleFor(x=>x.Email).NotEmpty()
                .Matches(@"^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$")
                .WithMessage("El Email deber tener un @ y una dirección válida.");
            RuleFor(x=>x.Password).NotEmpty().MinimumLength(5).MaximumLength(15)
                .Matches(@"[A-Z]+").Matches(@"[a-z]+").Matches(@"[0-9]+").Matches(@"[\@\!\?\.\*]+");
            RuleFor(x=>x.ConfirmPassword).NotEmpty().Equal(_ => _.Password);
            RuleFor(x=>x.PhoneNumber).NotEmpty().MinimumLength(10).MaximumLength(10)
                .Matches(@"^[0-9]{10}$")
                .WithMessage("Solo números; el Phone Number solo puede tener 10 dígitos y sin espacio.");
        }

        public Func<object, string, Task<IEnumerable<string>>> ValidateValue => async (model, propertyName) =>
        {
            var result = await ValidateAsync(ValidationContext<RegistrationModel>.CreateWithOptions((RegistrationModel)model, x => x.IncludeProperties(propertyName)));
            if (result.IsValid)
                return Array.Empty<string>();
            return result.Errors.Select(e => e.ErrorMessage);
        };
    }
}
