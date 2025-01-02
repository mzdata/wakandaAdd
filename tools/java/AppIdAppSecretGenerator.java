
import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.UUID;

public class AppIdAppSecretGenerator {


    public static String generateAppId() {
        return UUID.randomUUID().toString().replace("-", "");
    }

    public static String generateAppSecret(String appId) {
        try {
            MessageDigest md = MessageDigest.getInstance("SHA-256");
            byte[] hash = md.digest(appId.getBytes());

            StringBuilder sb = new StringBuilder();
            for (byte b : hash) {
                sb.append(String.format("%02x", b));
            }

            return sb.toString();
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        }

        return null;
    }

    public static void main(String[] args) {
    
        if (args.length >= 1) {
            String arg1 = args[0]; 
            String result =  generateAppSecret(arg1);
            System.out.println(result);

        } else {
            System.out.println("java xxx arg1  ");
        }
    }
}
