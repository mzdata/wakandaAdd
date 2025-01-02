

 
public class EnPwd {

    public static String enPwd(String password) {
        return   BCrypt.hashpw(password, BCrypt.gensalt());
    }

    public static void main(String[] args) {
        if (args.length >= 1) {
            String arg1 = args[0]; 
            String result =  enPwd(arg1);
            System.out.println(result);

        } else {
            System.out.println("java xxx arg1  ");
        }
    }
}