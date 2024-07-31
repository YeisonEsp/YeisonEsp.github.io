using System.ComponentModel.DataAnnotations;

namespace FormMudBlazor.Models
{
    public class RegistrationModel
    {
        public string? Name { get; set; }
        public string? Email { get; set; }
        public string? Password { get; set; }
        public string? ConfirmPassword { get; set; }
        [MaxLength(15)]
        [MinLength(10)]
        public string? PhoneNumber { get; set; }
    }
}
